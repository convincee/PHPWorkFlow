<?php
namespace PHPWorkFlow;

use PHPWorkFlow\DB\WorkItem;
use PHPWorkFlow\Enum\UseCaseStatusEnum;
use PHPWorkFlow\Enum\WorkItemStatusEnum;
use Propel\Runtime\Propel;

/**
 * Class WorkFlowTrafficker
 * @package PHPWorkFlow
 */
class WorkFlowTrafficker
{
    use WorkFlowDAOTrait;
    /**
     * @var $route string|null
     */
    protected $route = null;
    /**
     * @var $action WorkItem[]
     */
    protected $workItemObjArr = [];
    /**
     * @var $createdWorkItemObjArr WorkItem[]
     */
    protected $createdWorkItemObjArr = [];
    /**
     * @var null|string
     */
    protected $use_case_id = null;

    /**
     * @param bool|false $route
     * @param bool|false $use_case_id
     */
    public function __construct($route = false, $use_case_id = false)
    {
        /*
         * Check if there are any work_item for this particular controller/action pair, if yes create a WrokFlowEngineObj
         *
         */
        $this->route = $route;
        $this->use_case_id = $use_case_id;
    }

    /**
     *
     */
    public function populateWorkItems()
    {
        /*
         * create an arr of all active work item which match the current criteria
         */
        if ($this->route && $this->use_case_id) {
            $this->workItemObjArr = $this->getWorkFlowDAO()->FetchEnabledWorkItemArrWithUseCaseIdAndRoute(
                $this->use_case_id,
                $this->route
            );
        } elseif ($this->use_case_id) {
            $this->workItemObjArr = $this->getWorkFlowDAO()->FetchEnabledWorkItemArrWithUseCaseId($this->use_case_id);
        } elseif ($this->route) {
            $this->workItemObjArr = $this->getWorkFlowDAO()->FetchEnabledWorkItemArrWithRoute($this->route);
        } else {
            $this->workItemObjArr = $this->getWorkFlowDAO()->FetchWorkItemArrWithWorkItemStatus(
                WorkItemStatusEnum::ENABLED
            );
        }
    }

    /**
     * loop through all the enabled work_items that match this
     *
     * $workFlowTriggerObj->$triggerAction() will do the following
     *      0: Determine if the work_item in question has any inbound tokens waiting
     *      1: Determine if the work_item in question and been completed
     *      2: If no - do nothing
     *      3: If yes - Consume/Drop tokens as needed (the Consuming and dropping of tokens can lead to other processing.
     *
     * @param null $triggersToCheckWorkItemObjArr
     * @throws Exception_WorkFlow
     * @throws \Exception
     */
    public function checkWorkItemsForCompleteness($triggersToCheckWorkItemObjArr = null)
    {
        $this->populateWorkItems();
        if (!$this->workItemObjArr) {
            /**
             * looks like we here but nothing to do. Could be that this is a parent that is 'completed'
             * but incomplete children may be keeping it from being marked as such
             *
             * if $this->use_case_id is nll at this point - it's because this class
             * was instantiated with routes
             */
            if ($this->use_case_id) {
                $useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($this->use_case_id);

                if (
                    0 == count($useCaseObj->getOpenChildern()) &&
                    $useCaseObj->getUseCaseStatus() == UseCaseStatusEnum::OPEN
                ) {
                    $this->getWorkFlowDAO()->UpdateUseCaseWithUseCaseId(
                        $useCaseObj->getUseCaseId(),
                        [
                            'UseCaseStatus' => Enum\UseCaseStatusEnum::CLOSED,
                            'EndDate'       => time()
                        ]
                    );
                }
            }
            return;
        }
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            if ($triggersToCheckWorkItemObjArr === null) {
                $triggersToCheckWorkItemObjArr = $this->workItemObjArr;
            }
            $newTriggersToCheckWorkItemObjArr = [];
            foreach ($triggersToCheckWorkItemObjArr as $workItemObj) {
                if (!$this->check_trigger_elegability($workItemObj)) {
                    continue;
                }
                /*
                 * create a trigger class to test to see if the condition for success has been met for $workItemObj
                 */
                $triggerClassName = $workItemObj->getUseCase()->getWorkFlow()->getTriggerClass();
                $triggerMethod = $workItemObj->getTransition()->getTransitionTriggerMethod();

                /**
                 * @var $workFlowTriggerObj TriggerBase
                 */
                if (!class_exists('\PHPWorkFlow\\' . $triggerClassName)) {
                    $trigger_class_file = PHPWORKFLOW_TRIGGER_DIR  . $triggerClassName . '.php';
                    if (!file_exists($trigger_class_file)) {
                        throw new Exception_WorkFlow('No trigger class found');
                    }
                    require_once($trigger_class_file);
                }

                $nameSpacedTriggerClassName = '\PHPWorkFlow\\' . $triggerClassName;
                /** @var TriggerBase $workFlowTriggerObj */
                /**
                 * be sure to be using a 'fresh' WorkItem since prev processing may have made
                 * it not enabled
                 */
                $workItemObj = $this->getWorkFlowDAO()->FetchWorkItemWithWorkItemId(
                    $workItemObj->getWorkItemId()
                );

                $workFlowTriggerObj = new $nameSpacedTriggerClassName($workItemObj);
                /**
                 * Let's see if the tokens that first this TransitionTrigger are present
                 */
                if (!$workFlowTriggerObj->allNeededTokensAreInPlace()) {
                    throw new Exception_WorkFlow('Exception thrown in {$triggerinfo.triggerName} at ' . __FILE__ . ':' . __LINE__);
                }
                $workFlowTriggerObj->$triggerMethod();

                $newTriggersToCheckWorkItemObjArr = array_merge(
                    $newTriggersToCheckWorkItemObjArr,
                    $workFlowTriggerObj->get_createdWorkItemObjArr());
            }
            if ($newTriggersToCheckWorkItemObjArr) {
                /**
                 * now let's recursivly call checkWorkItemsForCompleteness, this time explicitly passing
                 * an array of newly minted WorkItemObj's
                 */
                $this->checkWorkItemsForCompleteness($newTriggersToCheckWorkItemObjArr);
            }
            $con->commit();
            return;
        } catch (Exception_WorkFlow $exceptionObj) {
            $con->rollBack();
            throw $exceptionObj;
        } catch (\Exception $exceptionObj) {
            $con->rollBack();
            throw new Exception_WorkFlow($exceptionObj->getMessage() . $exceptionObj->getTraceAsString());
        }
    }

    /**
     * @param WorkItem $workItemObj
     * @return bool
     */
    public function check_trigger_elegability(WorkItem $workItemObj)
    {
        if (!$workItemObj = $this->getWorkFlowDAO()->FetchWorkItemWithWorkItemId(
            $workItemObj->getWorkItemId()
        )
        ) {
            return false;
        }
        if ($workItemObj->getWorkItemStatus() == WorkItemStatusEnum::ENABLED) {
            return true;
        }
        return false;
    }
}
