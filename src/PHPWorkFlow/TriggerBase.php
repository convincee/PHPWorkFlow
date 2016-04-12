<?php
namespace PHPWorkFlow;

use PHPWorkFlow\DB\WorkItem;
use PHPWorkFlow\Enum\TokenStatusEnum;
use PHPWorkFlow\Enum\TriggerFulfillmentStatusEnum;
use PHPWorkFlow\Enum\WorkItemStatusEnum;

/**
 * Class TriggerBase
 * @package PHPWorkFlow
 */
class TriggerBase
{
    use WorkFlowDAOTrait;
    use TriggerFulfillmentUtilTrait;
    /**
     * @var WorkItem
     */
    protected $workItemObj;
    /**
     * @var WorkFlowEngine
     */
    protected $workFlowEngineObj;
    /**
     * @var WorkItem[]
     */
    protected $createdWorkItemObjArr = [];
    /******************************************
     * Wizard and WorkFlow Support
     * ***************************************
     *
     * @var bool|int
     */
    public $work_flow_next_link = false;
    /******************************************
     * END OF Wizard and WorkFlow Support
     * ***************************************
     */

    /**
     * @param WorkItem $workItemObj
     *
     */
    public function __construct(WorkItem $workItemObj = null)
    {
        if (!$workItemObj) {
            return;
        }
        $this->workItemObj = $workItemObj;
        $this->workFlowEngineObj = new WorkFlowEngine ($this->workItemObj->getUseCaseId());
    }

    /**
     * @return bool
     * @throws Exception_WorkFlow
     */
    protected function pullTheTrigger()
    {
        /**
         * if exists, mark transition_requirement and consumed
         */
        if ($triggerFulfillmentObjArr = $this->getTriggerFulfillmentUtil()->FetchTriggerFulfillmentArrWithUseCaseIdAndTransitionIdAndTriggerFulfillmentStatus(
            $this->workItemObj->getUseCaseId(),
            $this->workItemObj->getTransitionId(),
            TriggerFulfillmentStatusEnum::FREE
        )
        ) {
            foreach ($triggerFulfillmentObjArr as $triggerFulfillmentObj) {
                $this->getTriggerFulfillmentUtil()->UpdateTriggerFulfillment(
                    $triggerFulfillmentObj->getTriggerFulfillmentId(),
                    [
                        'TriggerFulfillmentStatus' => TriggerFulfillmentStatusEnum::CONSUMED
                    ]
                );
            }
        }
        /*
         * Cool - now that we know we have fulfilled the workItem, lets make this WorkItem = finished, consume the proper tokens,
         * and finally drop new tokens
         *
         * 'finish' work item
         */
        $this->markWorkItemFinished();

        /*
         * consume all inbound tokens - this will also take care of marking any workItems that were hoping
         * to consume a token that this WorkItem is instead consuming
         */
        $this->consumeAllInboundTokens();
        /*
         * drop outbound tokens as appropriate - this may also generate new WorkItems
         */
        $this->dropOutboundTokens();
        return true;
    }

    /**
     * @param $transition_id_arr
     * @throws Exception_WorkFlow
     */
    protected function pullTheTriggerOnGate($transition_id_arr)
    {
        $this->pullTheTrigger();
        foreach ($this->get_createdWorkItemObjArr() as $workItemObj) {
            if (!in_array($workItemObj->getTransitionId(), $transition_id_arr)) {
                $this->getWorkFlowDAO()->UpdateWorkItem(
                    $workItemObj->getWorkItemId(),
                    [
                        'WorkItemStatus' => WorkItemStatusEnum::CANCELLED,
                        'CancelledDate'  => time()
                    ]
                );
                foreach ($workItemObj->getFreeInboundTokenArr() as $tokenObj) {
                    $this->getWorkFlowDAO()->UpdateToken(
                        $tokenObj->getTokenId(),
                        [
                            'TokenStatus'   => TokenStatusEnum::CANCELLED,
                            'CancelledDate' => time()
                        ]
                    );
                }
            }
        }
    }

    /**
     * @return WorkItem
     */
    protected function markWorkItemFinished()
    {
        return $this->getWorkFlowDAO()->UpdateWorkItem(
            $this->workItemObj->getWorkItemId(),
            [
                'WorkItemStatus' => WorkItemStatusEnum::FINISHED,
                'FinishedDate'   => time()
            ]
        );
    }

    /**
     * @return void
     */
    protected function consumeAllInboundTokens()
    {
        foreach ($this->workItemObj->getFreeInboundTokenArr() as $tokenObj) {
            $this->workFlowEngineObj->ConsumeToken($tokenObj, $this->workItemObj->getWorkItemId());
        }
    }

    /**
     * @return bool
     */
    protected function dropOutboundTokens()
    {
        foreach ($this->workItemObj->getOutboundPlaceArr() as $placeObj) {
            $this->workFlowEngineObj->DropToken(
                $placeObj,
                TokenStatusEnum::FREE,
                $this->workItemObj->getWorkItemId()
            );
        }

        $this->createdWorkItemObjArr = array_merge(
            $this->workFlowEngineObj->get_allWorkItemsCreatedObjArr(),
            $this->get_createdWorkItemObjArr());
        return true;
    }

    /**
     * @return bool
     */
    public function allNeededTokensAreInPlace()
    {
        /*
         * Are all the Tokens that are needed to fire this workItem in place??
         */
        $inboundPlaceObjArr = $this->workItemObj->getInboundPlaceArr();
        foreach ($inboundPlaceObjArr as $inboundPlaceObj) {
            $tokenObj = $this->getWorkFlowDAO()->FetchEnabledTokenWithUseCaseIdAndPlaceIdArr(
                $this->workItemObj->getUseCaseId(),
                $inboundPlaceObj->getPlaceId()
            );
            if (!$tokenObj) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array|WorkItem[]
     */
    public function get_createdWorkItemObjArr()
    {
        /*
         * since the 'trigger' process can modify WorkItems, we need to .......
         */
        $refreshedWorkItemObjArr = [];
        foreach ($this->createdWorkItemObjArr as $workItemObj) {
            if (!$freshWorkItemObj = $this->getWorkFlowDAO()->FetchWorkItemWithWorkItemId(
                $workItemObj->getWorkItemId()
            )
            ) {
                continue;
            }
            if ($freshWorkItemObj->getWorkItemStatus() == WorkItemStatusEnum::ENABLED) {
                $refreshedWorkItemObjArr[] = $freshWorkItemObj;
            }
        }
        $this->createdWorkItemObjArr = $refreshedWorkItemObjArr;
        return $this->createdWorkItemObjArr;
    }
}
