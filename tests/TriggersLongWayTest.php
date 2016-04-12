<?php

require_once __DIR__.'/../PHPWorkFlow.init.php';

/**
 * Class WorkFlowTest
 *
 * @backupGlobals          disabled
 * @backupStaticAttributes disabled
 * @codeCoverageIgnore
 */
class TriggersLongWayTest extends PHPWorkFlow_Framework_TestCase_Integration
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
    public function testTriggersLongWay(PHPWorkFlow\DB\WorkFlow $workFlowObj)
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

        $this->assertEquals(1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR45EmailStaffStartingAddOrganizationTriggerUser'
            )
        );
        $this->assertEquals(1,
            $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount(
                $useCaseObj->getUseCaseId(),
                'TR15EmailSuperFailureTriggerTimed'
            )
        );

        /* do something */
        $this->doSomething($useCaseObj, 'TR45EmailStaffStartingAddOrganizationTriggerUser', $i++, 3, 1, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR1AddOrgType1TriggerUser', $i++, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR3InviteBuildUserTriggerUser', $i++, 2, 2, __FUNCTION__);

        /*
         * here is we take the 'long way' around the TR22 loop
         */
        $this->doSomething($useCaseObj, 'TR22BuildUserRegistersLoop1TriggerUser', $i++, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR26BuildUserRegistersLoop2TriggerUser', $i++, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR30BuildUserRegistersLoop1TriggerUser', $i++, 2, 2, __FUNCTION__);
        $this->getTriggerFulfillmentUtil()->CreateTriggerFulfillment(

            [
                'UseCaseId'    => $useCaseObj->getUseCaseId(),
                'TransitionId' => $this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod(
                    $useCaseObj->getWorkFlowId(),
                    'TR5BuildUserRegistersTriggerGate'
                )->getTransitionId()
            ]
        );
        $this->doSomething($useCaseObj, 'TR31BuildUserRegistersLoop1TriggerUser', $i++, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR20CreateBuildUserConfigTriggerUser', $i++, 4, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR9AddBuildUserWorkPhoneTriggerUser', $i++, 3, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR10AddBuildUser24x7PhoneTriggerUser', $i++, 2, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR11AddBuildUserCellPhoneTriggerUser', $i++, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR2InviteTeamAgentTriggerUser', $i++, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR4TeamAgentRegistersTriggerUser', $i++, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR19CreateTeamAgentConfigTriggerUser', $i++, 4, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR6AddTeamAgentWorkPhoneTriggerUser', $i++, 3, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR8AddTeamAgentCellPhoneTriggerUser', $i++, 2, 4, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR7AddTeamAgentHomePhoneTriggerUser', $i++, 2, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR17AddTeamAgentFaxPhoneTriggerUser', $i++, 1, 2, __FUNCTION__);
        $this->doSomething($useCaseObj, 'TR18AddBuildFaxPhoneTriggerUser', $i++, 0, 0, __FUNCTION__);

        $useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($useCaseObj->getUseCaseId());
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::CLOSED, $useCaseObj->getUseCaseStatus());
    }
}