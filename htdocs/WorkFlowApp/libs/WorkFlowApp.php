<?php
/**
 * WorkFlowApp application library
 */
use Propel\Runtime\Propel;
use PHPWorkFlow\Exception_WorkFlow;

/**
 * Class WorkFlowApp
 */
class WorkFlowApp
{
    use \PHPWorkFlow\WorkFlowDAOTrait;
    use \PHPWorkFlow\PNMLTrait;
    use \PHPWorkFlow\TriggerFulfillmentUtilTrait;
    use \PHPWorkFlow\TriggerUtilTrait;

    /**
     * @var WorkFlowApp_Smarty|null
     */
    private $tpl;
    // error messages
    private $error;

    /**
     * class constructor
     */
    public function __construct()
    {
        // instantiate the template object
        $this->tpl = new WorkFlowApp_Smarty;
        /**
         * @todo fix me
         */
        $this->tpl->caching = 0;
        $this->tpl->clearAllCache();
    }

    /**
     * @param $work_flow_id
     */
    public function deleteWorkFlow($work_flow_id)
    {
        $this->getWorkFlowDAO()->DeleteWorkFlowWithWorkFlowId($work_flow_id);
    }

    /**
     * @param $use_case_id
     */
    public function deleteUseCase($use_case_id)
    {
        $this->getWorkFlowDAO()->DeleteUseCaseWithUseCaseId($use_case_id);
    }

    /**
     * @param array $formvars
     */
    public function displayWorkFlowForm($formvars = [])
    {
        // assign the form vars
        $this->tpl->assign('post', $formvars);
        // assign error message
        $this->tpl->assign('error', $this->error);
        $this->tpl->display('WorkFlow_form.tpl');
    }

    /**
     * @param array $formvars
     */
    public function displayTriggerFulfillmentForm($formvars = [])
    {
        $useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($formvars['UseCaseId']);
        $TransitionOptions = [];
        $TransitionDefaultSelect = null;
        foreach ($useCaseObj->getWorkFlow()->getTransitions() as $transitionObj) {
            /**
             * if already exists....
             */
            if ($this->getTriggerFulfillmentUtil()->FetchTriggerFulfillmentArrWithUseCaseIdAndTransitionIdAndTriggerFulfillmentStatus(
                $useCaseObj->getUseCaseId(),
                $transitionObj->getTransitionId(),
                \PHPWorkFlow\Enum\TriggerFulfillmentStatusEnum::FREE
            )
            ) {
                continue;
            }
            if (
                $transitionObj->getTransitionType() == \PHPWorkFlow\Enum\TransitionTypeEnum::USER ||
                $transitionObj->getTransitionType() == \PHPWorkFlow\Enum\TransitionTypeEnum::GATE
            ) {
                $TransitionOptions[$transitionObj->getTransitionId()] = $transitionObj->getTransitionTriggerMethod();
                if (!$TransitionDefaultSelect) {
                    $TransitionDefaultSelect = $transitionObj->getTransitionTriggerMethod();
                }
            }
        }
        // assign the form vars
        $this->tpl->assign('UseCaseId', $useCaseObj->getUseCaseId());
        $this->tpl->assign('UseCaseName', $useCaseObj->getName());
        $this->tpl->assign('TransitionOptions', $TransitionOptions);
        $this->tpl->assign('TransitionDefaultSelect', $TransitionDefaultSelect);
        $this->tpl->assign('post', $formvars);
        // assign error message
        $this->tpl->assign('error', $this->error);
        $this->tpl->display('TriggerFulfillment_form.tpl');
    }

    /**
     * @param array $formvars
     */
    public function displayUseCaseForm($formvars = [])
    {
        $WorkFlowOptions = [];
        $WorkFlowDefaultSelect = null;
        foreach ($this->getWorkFlowDAO()->FetchWorkFlowArr() as $workFlowObj) {
            $WorkFlowOptions[$workFlowObj->getWorkFlowId()] = $workFlowObj->getName();
            if (!$WorkFlowDefaultSelect) {
                $WorkFlowDefaultSelect = $workFlowObj->getWorkFlowId();
            }
        }
        // assign the form vars
        $this->tpl->assign('WorkFlowOptions', $WorkFlowOptions);
        $this->tpl->assign('WorkFlowDefaultSelect', $WorkFlowDefaultSelect);
        $this->tpl->assign('post', $formvars);
        // assign error message
        $this->tpl->assign('error', $this->error);
        $this->tpl->display('UseCase_form.tpl');

    }

    /**
     * @param array $file
     * @return \PHPWorkFlow\DB\WorkFlow
     * @throws Exception
     * @throws Exception_WorkFlow
     */
    public function addWorkFlow($file = [])
    {
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $workFlowObj = $this->getPNMLBusiness()->UploadPNML($file['datafile']['tmp_name']);
            $con->commit();
        } catch (Exception_WorkFlow $exceptionObj) {
            $con->rollBack();
            throw $exceptionObj;
        } catch (\Exception $exceptionObj) {
            $con->rollBack();
            throw new Exception_WorkFlow($exceptionObj->getMessage() . $exceptionObj->getTraceAsString());
        }
        $this->getTriggerUtil()->GenerateWorkFlowTriggerClass($workFlowObj);
        return $workFlowObj;
    }

    /**
     * @param array $post
     * @return bool
     * @throws Exception
     * @throws Exception_WorkFlow
     */
    public function addUseCase($post = [])
    {
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $useCaseObj = $this->getWorkFlowDAO()->CreateUseCase($post);
            $con->commit();
        } catch (Exception_WorkFlow $exceptionObj) {
            $con->rollBack();
            throw $exceptionObj;
        } catch (\Exception $exceptionObj) {
            $con->rollBack();
            throw new Exception_WorkFlow($exceptionObj->getMessage() . $exceptionObj->getTraceAsString());
        }
        return $useCaseObj;
    }

    /**
     * @param array $post
     * @return mixed
     * @throws Exception
     * @throws Exception_WorkFlow
     */
    public function addTriggerFulfillment($post = [])
    {
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $triggerFulfillmentObj = $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment($post);
            $con->commit();
        } catch (Exception_WorkFlow $exceptionObj) {
            $con->rollBack();
            throw $exceptionObj;
        } catch (\Exception $exceptionObj) {
            $con->rollBack();
            throw new Exception_WorkFlow($exceptionObj->getMessage() . $exceptionObj->getTraceAsString());
        }
        return $triggerFulfillmentObj;
    }

    /**
     * @param $focus
     */
    public function displayIndexPage($focus)
    {
        $work_flow_content = $this->getWorkFlowContent();
        $open_use_case_content = $this->getUseCaseContentWithUseCaseStatus(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN);
        $all_use_case_content = $this->getUseCaseContentWithUseCaseStatus();
        $enabled_work_item_content = $this->getWorkItemContentWithWorkItemStatus(\PHPWorkFlow\Enum\WorkItemStatusEnum::ENABLED);
        $enabled_token_content = $this->getFreeTokenContent();
        $trigger_fulfillment_content = $this->getTriggerFulfillmentContent();

        $this->tpl->assign('work_flow_content', $work_flow_content);
        $this->tpl->assign('open_use_case_content', $open_use_case_content);
        $this->tpl->assign('all_use_case_content', $all_use_case_content);
        $this->tpl->assign('enabled_work_item_content', $enabled_work_item_content);
        $this->tpl->assign('enabled_token_content', $enabled_token_content);
        $this->tpl->assign('trigger_fulfillment_content', $trigger_fulfillment_content);
        $this->tpl->assign('focus', $focus);
        $this->tpl->display('MainPage.tpl');
    }

    /**
     * @return string
     */
    public function getWorkFlowContent()
    {
        $workFlowObjArr = $this->getWorkFlowDAO()->FetchWorkFlowArr();
        $work_flow_data = [];
        $cols = [];
        foreach ($workFlowObjArr as $workFlowObj) {
            $work_flow_data[] = [
                'WorkFlowId_'  => $workFlowObj->getWorkFlowId(),
                'WorkFlowName' => $workFlowObj->getName() . '(' . $workFlowObj->getWorkFlowId() . ')',
                'Description'  => $workFlowObj->getDescription(),
                'TriggerClass' => $workFlowObj->getTriggerClass()
            ];
            $cols = array_keys($work_flow_data[0]);
        }
        $this->tpl->assign('data', $work_flow_data);
        $this->tpl->assign('cols', $cols);
        $this->tpl->assign('focus', 'WorkFlow');
        $work_flow_content = $this->tpl->fetch('WorkFlow.tpl');
        return $work_flow_content;
    }

    /**
     * @param null $use_case_status
     * @return string
     */
    public function getUseCaseContentWithUseCaseStatus($use_case_status = null)
    {
        $useCaseObjArr = $this->getWorkFlowDAO()->FetchUseCaseArrWithUseCaseStatus($use_case_status);
        $use_case_data = [];
        $cols = [];
        foreach ($useCaseObjArr as $useCaseObj) {
            $use_case_data[] = [
                'WorkFlowName'          => $useCaseObj->getWorkFlow()->getName() . '(' . $useCaseObj->getWorkFlowId() . ')',
                'WorkFlowId_'           => $useCaseObj->getWorkFlowId(),
                'UseCaseId_'            => $useCaseObj->getUseCaseId(),
                'UseCaseName'           => $useCaseObj->getName() . '(' . $useCaseObj->getUseCaseId() . ')',
                'UseCaseStatus'         => $useCaseObj->getUseCaseStatus(),
                'Description'           => $useCaseObj->getDescription(),
                'WorkItems'             => $useCaseObj->getEnabledWorkItemCount(),
                'UseCaseGroup'          => $useCaseObj->getUseCaseGroup(),
                'Type(ParentUseCaseId)' => $useCaseObj->getParentUseCaseId() ? 'Child(' . $useCaseObj->getParentUseCaseId() . ')' : 'Parent'
            ];
            $cols = array_keys($use_case_data[0]);
        }
        $this->tpl->assign('data', $use_case_data);
        $this->tpl->assign('cols', $cols);
        $this->tpl->assign('focus', 'UseCase');
        $open_use_case_content = $this->tpl->fetch('UseCase.tpl');
        return $open_use_case_content;
    }

    /**
     * @param null $work_item_status
     * @return string
     */
    public function getWorkItemContentWithWorkItemStatus($work_item_status = null)
    {
        $workItemObjArr = $this->getWorkFlowDAO()->FetchWorkItemArrWithWorkItemStatus($work_item_status);
        $work_item_data = [];
        $cols = [];
        foreach ($workItemObjArr as $workItemObj) {
            $work_item_data[] = [
                'WorkFlowName'            => $workItemObj->getUseCase()->getWorkFlow()->getName() . '(' . $workItemObj->getUseCase()->getWorkFlowId() . ')',
                'UseCaseName'             => $workItemObj->getUseCase()->getName() . '(' . $workItemObj->getUseCaseId() . ')',
                'WorkFlowId_'             => $workItemObj->getUseCase()->getWorkFlowId(),
                'UseCaseId_'              => $workItemObj->getUseCase()->getUseCaseId(),
                'TransitionType'          => $workItemObj->getTransition()->getTransitionType(),
                'TransitionTriggerMethod' => $workItemObj->getTransition()->getTransitionTriggerMethod()
            ];
            $cols = array_keys($work_item_data[0]);
        }
        $this->tpl->assign('data', $work_item_data);
        $this->tpl->assign('cols', $cols);
        $this->tpl->assign('focus', 'WorkItem');
        $enabled_work_item_content = $this->tpl->fetch('WorkItem.tpl');
        return $enabled_work_item_content;
    }

    /**
     * @return string
     */
    public function getFreeTokenContent()
    {
        $tokenObjArr = $this->getWorkFlowDAO()->FetchFreeInboundTokensArr();
        $token_data = [];
        $cols = [];
        foreach ($tokenObjArr as $tokenObj) {
            $inwardArcArr = $tokenObj->getPlace()->getInwardArcArr();
            $arcType = $inwardArcArr[0]->getArcType();
            $this_token_data = [
                'TokenId'            => $tokenObj->getTokenId(),
                'WorkFlowName'       => $tokenObj->getUseCase()->getWorkFlow()->getName() . '(' . $tokenObj->getUseCase()->getWorkFlowId() . ')',
                'UseCaseId_'         => $tokenObj->getUseCase()->getUseCaseId(),
                'UseCaseName'        => $tokenObj->getUseCase()->getName() . '(' . $tokenObj->getUseCase()->getUseCaseId() . ')',
                'PlaceName'          => $tokenObj->getPlace()->getName(),
                'ArcType'            => $arcType,
                'PotentialWorkItems' => []
            ];
            $cols = array_keys($this_token_data);
            foreach ($tokenObj->GetInboundWorkItems() as $workItemObj) {
                $this_token_data['PotentialWorkItems'][] = [
                    'UseCaseId_'              => $tokenObj->getUseCase()->getUseCaseId(),
                    'WorkItemId'              => $workItemObj->getWorkItemId(),
                    'TransitionName'          => $workItemObj->getTransition()->getName(),
                    'TransitionType'          => $workItemObj->getTransition()->getTransitionType(),
                    'TransitionTriggerMethod' => $workItemObj->getTransition()->getTransitionTriggerMethod()
                ];
            }
            $token_data[] = $this_token_data;
        }
        $this->tpl->assign('data', $token_data);
        $this->tpl->assign('cols', $cols);
        $this->tpl->assign('focus', 'Token');
        $enabled_token_content = $this->tpl->fetch('Token.tpl');
        return $enabled_token_content;
    }

    /**
     * @return string
     */
    public function getTriggerFulfillmentContent()
    {
        $triggerFulfillmentObjArr = $this->getTriggerFulfillmentUtil()->FetchOpenUseCasesTriggerFulfillmentArr();
        $token_data = [];
        foreach ($triggerFulfillmentObjArr as $triggerFulfillmentObj) {
            $token_data[] = [
                'TriggerFulfillmentId'     => $triggerFulfillmentObj->getTriggerFulfillmentId(),
                'WorkFlowName'             => $triggerFulfillmentObj->getUseCase()->getWorkFlow()->getName() . '(' . $triggerFulfillmentObj->getUseCase()->getWorkFlowId() . ')',
                'UseCaseName'              => $triggerFulfillmentObj->getUseCase()->getName() . '(' . $triggerFulfillmentObj->getUseCase()->getUseCaseId() . ')',
                'UseCaseId'                => $triggerFulfillmentObj->getUseCase()->getUseCaseId(),
                'TriggerFulfillmentStatus' => $triggerFulfillmentObj->getTriggerFulfillmentStatus(),
                'TransitionTriggerMethod'  => $triggerFulfillmentObj->getTransition()->getTransitionTriggerMethod()
            ];
        }
        $cols = ['UseCaseName', 'TriggerFulfillmentStatus', 'TransitionTriggerMethod'];
        $this->tpl->assign('data', $token_data);
        $this->tpl->assign('cols', $cols);
        $this->tpl->assign('focus', 'TriggerFulfillment');
        $enabled_trigger_fulfillment_content = $this->tpl->fetch('TriggerFulfillment.tpl');
        return $enabled_trigger_fulfillment_content;
    }

    /**
     * @param $params
     * @throws Exception
     * @throws Exception_WorkFlow
     */
    public function triggerWorkItem($params)
    {
        if (!$useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($params['UseCaseId'])) {
            throw new Exception_WorkFlow('cannot find $useCaseObj in question');
        }
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment(
                [
                    'UseCaseId'    => $params['UseCaseId'],
                    'TransitionId' => $this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod(
                        $useCaseObj->getWorkFlowId(),
                        $params['TransitionTriggerMethod']
                    )->getTransitionId()
                ]
            );
        } catch (Exception_WorkFlow $exceptionObj) {
            $con->rollBack();
            throw $exceptionObj;
        } catch (\Exception $exceptionObj) {
            $con->rollBack();
            throw new Exception_WorkFlow($exceptionObj->getMessage() . $exceptionObj->getTraceAsString());
        }

        try {
            $this->pushUseCase($params);
            $con->commit();
        } catch (Exception_WorkFlow $exceptionObj) {
            $con->rollBack();
            throw $exceptionObj;
        } catch (\Exception $exceptionObj) {
            $con->rollBack();
            throw new Exception_WorkFlow($exceptionObj->getMessage() . $exceptionObj->getTraceAsString());
        }
    }

    /**
     * @param $params
     * @throws Exception
     * @throws Exception_WorkFlow
     */
    public function pushUseCase($params)
    {
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $WorkFlowEngine = new PHPWorkFlow\WorkFlowEngine($params['UseCaseId']);
            $WorkFlowEngine->PushWorkItems();
            $con->commit();
        } catch (Exception_WorkFlow $exceptionObj) {
            $con->rollBack();
            throw $exceptionObj;
        } catch (\Exception $exceptionObj) {
            $con->rollBack();
            throw new Exception_WorkFlow($exceptionObj->getMessage() . $exceptionObj->getTraceAsString());
        }
    }

    /**
     * @param $params
     * @throws Exception_WorkFlow
     */
    public function generate_PNML($params)
    {
        if (!$params['WorkFlowId']) {
            throw new \PHPWorkFlow\Exception_WorkFlow('Invalid work_flow or use case ID specified');
        }
        $params['UseCaseId'] = $params['UseCaseId'] ? $params['UseCaseId'] : null;
        $work_flow_xml = $this->getPNMLBusiness()->GeneratePNML($params['WorkFlowId'], $params['UseCaseId']);
        if ($params['UseCaseId']) {
            $name = 'UseCase.' . date('Y_m_j_H_i_s_T', time()) . '.pnml';
        } else {
            $name = 'WorkFlow.' . date('Y_m_j_H_i_s_T', time()) . '.pnml';
        }

        $this->page = false;
        header('content-type: file/xml');
        header("Content-Disposition: filename=\"$name\"");

        file_put_contents(PHPWORKFLOW_ARTIFACTS_DIR . $name, $work_flow_xml);

        echo $work_flow_xml;
        return;
    }

    /**
     * @param $params
     * @throws Exception
     * @throws Exception_WorkFlow
     */
    public function deleteTriggerFulfillmentWithUseCaseIdAndTransitionTriggerMethod($params)
    {
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $this->getTriggerFulfillmentUtil()->DeleteTriggerFulfillmentWithTriggerFulfillmentId(
                $params['TriggerFulfillmentId']
            );
            $con->commit();
        } catch (Exception_WorkFlow $exceptionObj) {
            $con->rollBack();
            throw $exceptionObj;
        } catch (\Exception $exceptionObj) {
            $con->rollBack();
            throw new Exception_WorkFlow($exceptionObj->getMessage() . $exceptionObj->getTraceAsString());
        }
    }

    /**
     * @param $params
     * @throws Exception
     * @throws Exception_WorkFlow
     */
    public function deleteAllTriggerFulfillmentWithUseCaseId($params)
    {
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $this->getTriggerFulfillmentUtil()->DeleteTriggerFulfillmentWithUseCaseId($params['UseCaseId']);
            $con->commit();
        } catch (Exception_WorkFlow $exceptionObj) {
            $con->rollBack();
            throw $exceptionObj;
        } catch (\Exception $exceptionObj) {
            $con->rollBack();
            throw new Exception_WorkFlow($exceptionObj->getMessage() . $exceptionObj->getTraceAsString());
        }
    }

    /**
     * @return null|WorkFlowApp_Smarty
     */
    public function getTpl()
    {
        return $this->tpl;
    }

    /**
     * @param null|WorkFlowApp_Smarty $tpl
     */
    public function setTpl($tpl)
    {
        $this->tpl = $tpl;
    }

    /**
     * @return null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param null $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }
}