<?php

require_once __DIR__.'/../PHPWorkFlow.init.php';

/**
 * Class WorkFlowTest
 *
 * @backupGlobals          disabled
 * @backupStaticAttributes disabled
 * @codeCoverageIgnore
 */
class TraffickerTest extends PHPWorkFlow_Framework_TestCase_Integration
{
    /**
     * @return \PHPWorkFlow\DB\WorkFlow
     * @throws Exception
     * @throws \PHPWorkFlow\Exception_WorkFlow
     */
    public function testCreateWorkFlow()
    {
        if(! $workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithName('Test Work Flow'))
        {
            $workFlowObj = $this->getPNMLBusiness()->UploadPNML(PHPWORKFLOW_ARTIFACTS_DIR . '/TestWorkFlow.pnml');
            $this->getTriggerUtil()->GenerateWorkFlowTriggerClass($workFlowObj);
        }
        return $workFlowObj;
    }

    /**
     * @throws Exception
     * @throws \PHPWorkFlow\Exception_WorkFlow
     * @depends testCreateWorkFlow
     */
    public function testWorkFlowTrafficker(PHPWorkFlow\DB\WorkFlow $workFlowObj)
    {
        $useCaseObj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'    => $workFlowObj->getWorkFlowId(),
                'Name'          => 'Test work flow - testTriggersLongWay',
                'Description'   => 'Test work flow - testTriggersLongWay',
                'UseCaseStatus' => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN
            ]
        );
        $i = 0;
        $this->saveOffPnml($workFlowObj, $useCaseObj, $i++, __FUNCTION__);

        $this->assertEquals(2, $useCaseObj->getEnabledWorkItemCount());
        $this->assertEquals(1, $useCaseObj->getFreeTokenCount());

        /**
         * call WorkFlowTrafficker by UseCaseId
         */
        $this->assertEquals(
            1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR45EmailStaffStartingAddOrganizationTriggerUser'
            ),
            'trying to do TR45EmailStaffStartingAddOrganizationTriggerUser but no workitem found -  use_case_id = ' . $useCaseObj->getUseCaseId()
        );
        $this->assertEquals(
            1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR45EmailStaffStartingAddOrganizationTriggerUser'
            ),
            'trying to do TR1AddOrgType1TriggerUser but no workitem found -  use_case_id = ' . $useCaseObj->getUseCaseId()
        );
        $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment(
            [
                'UseCaseId'              => $useCaseObj->getUseCaseId(),
                'TransitionId'  =>$this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod(
                    $useCaseObj->getWorkFlowId(),
                    'TR45EmailStaffStartingAddOrganizationTriggerUser'
                )->getTransitionId()
            ]
        );
        $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment(
            [
                'UseCaseId'              => $useCaseObj->getUseCaseId(),
                'TransitionId'  =>$this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod(
                    $useCaseObj->getWorkFlowId(),
                    'TR1AddOrgType1TriggerUser'
                )->getTransitionId()
            ]
        );
        $workFlowTraffickerObj = new PHPWorkFlow\WorkFlowTrafficker(null, $useCaseObj->getUseCaseId());
        $workFlowTraffickerObj->checkWorkItemsForCompleteness();
        $this->saveOffPnml($workFlowObj, $useCaseObj, $i++, __FUNCTION__);

        $this->assertEquals(2, $useCaseObj->getEnabledWorkItemCount());
        $this->assertEquals(2, $useCaseObj->getFreeTokenCount());
        $this->assertEquals(
            1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR2InviteTeamAgentTriggerUser'
            ),
            'trying to do TR2InviteTeamAgentTriggerUser but no workitem found -  use_case_id = ' . $useCaseObj->getUseCaseId()
        );
        $this->assertEquals(
            1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR3InviteBuildUserTriggerUser'
            ),
            'trying to do TR3InviteBuildUserTriggerUser but no workitem found -  use_case_id = ' . $useCaseObj->getUseCaseId()
        );

        /**
         * call WorkFlowTrafficker by Route & UseCaseId
         */
        $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment(
            [
                'UseCaseId'              => $useCaseObj->getUseCaseId(),
                'TransitionId'  =>$this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod(
                    $useCaseObj->getWorkFlowId(),
                    'TR3InviteBuildUserTriggerUser'
                )->getTransitionId()
            ]
        );
        foreach ($useCaseObj->getWorkItems() as $workItemObj) {
            foreach ($workItemObj->getTransition()->getRoutes() as $routeObj) {
                $workFlowTraffickerObj = new PHPWorkFlow\WorkFlowTrafficker($routeObj->getRoute(),
                    $useCaseObj->getUseCaseId());
                $workFlowTraffickerObj->checkWorkItemsForCompleteness();
            }
        }
        $this->saveOffPnml($workFlowObj, $useCaseObj, $i++, __FUNCTION__);

        /**
         * call WorkFlowTrafficker by Route
         */
        $this->assertEquals(2, $useCaseObj->getEnabledWorkItemCount());
        $this->assertEquals(2, $useCaseObj->getFreeTokenCount());
        $this->assertEquals(
            1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR2InviteTeamAgentTriggerUser'
            ),
            'trying to do TR20CreateBuildUserConfigTriggerUser but no workitem found -  use_case_id = ' . $useCaseObj->getUseCaseId()
        );
        $this->assertEquals(
            1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR5BuildUserRegistersTriggerGate'
            ),
            'trying to do TR20CreateBuildUserConfigTriggerUser but no workitem found -  use_case_id = ' . $useCaseObj->getUseCaseId()
        );
        $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment(
            [
                'UseCaseId'              => $useCaseObj->getUseCaseId(),
                'TransitionId'  =>$this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod(
                    $useCaseObj->getWorkFlowId(),
                    'TR5BuildUserRegistersTriggerGate'
                )->getTransitionId()
            ]
        );
        $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment(
            [
                'UseCaseId'              => $useCaseObj->getUseCaseId(),
                'TransitionId'  =>$this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod(
                    $useCaseObj->getWorkFlowId(),
                    'TR20CreateBuildUserConfigTriggerUser'
                )->getTransitionId()
            ]
        );
        /**
         * NOTE NOTE NOTE
         * since TR5BuildUserRegistersTriggerGate is a gate (thus no route, I do not expect anything to trigger
         */
        foreach ($useCaseObj->getWorkItems() as $workItemObj) {
            foreach ($workItemObj->getTransition()->getRoutes() as $routeObj) {
                $workFlowTraffickerObj = new PHPWorkFlow\WorkFlowTrafficker($routeObj->getRoute(), null);
                $workFlowTraffickerObj->checkWorkItemsForCompleteness();
            }
        }
        $this->saveOffPnml($workFlowObj, $useCaseObj, $i++, __FUNCTION__);
        $this->assertEquals(2, $useCaseObj->getEnabledWorkItemCount());

        $this->assertEquals(2, $useCaseObj->getEnabledWorkItemCount());
        $this->assertEquals(2, $useCaseObj->getFreeTokenCount());
        $this->assertEquals(
            1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR2InviteTeamAgentTriggerUser'
            ),
            "trying to do TR2InviteTeamAgentTriggerUser but no workitem found -  use_case_id = " . $useCaseObj->getUseCaseId()
        );
        $this->assertEquals(
            1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR5BuildUserRegistersTriggerGate'
            ),
            "trying to do TR5BuildUserRegistersTriggerGate but no workitem found -  use_case_id = " . $useCaseObj->getUseCaseId()
        );
        /**
         * this should trigger TR5BuildUserRegistersTriggerGate
         */
        $workFlowTraffickerObj = new PHPWorkFlow\WorkFlowTrafficker(null, $useCaseObj->getUseCaseId());
        $workFlowTraffickerObj->checkWorkItemsForCompleteness();
        $this->saveOffPnml($workFlowObj, $useCaseObj, $i++, __FUNCTION__);

        $this->assertEquals(4, $useCaseObj->getEnabledWorkItemCount());
        $this->assertEquals(4, $useCaseObj->getFreeTokenCount());
        $this->assertEquals(
            1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR2InviteTeamAgentTriggerUser'
            ),
            'trying to do TR2InviteTeamAgentTriggerUser but no workitem found -  use_case_id = ' . $useCaseObj->getUseCaseId()
        );
        $this->assertEquals(
            1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR9AddBuildUserWorkPhoneTriggerUser'
            ),
            'trying to do TR9AddBuildUserWorkPhoneTriggerUser but no workitem found -  use_case_id = ' . $useCaseObj->getUseCaseId()
        );
    }
}