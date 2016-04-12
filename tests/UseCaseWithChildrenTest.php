<?php

require_once __DIR__.'/../PHPWorkFlow.init.php';

/**
 * Class WorkFlowTest
 *
 * @backupGlobals          disabled
 * @backupStaticAttributes disabled
 * @codeCoverageIgnore
 */
class UseCaseWithChildrenTest extends PHPWorkFlow_Framework_TestCase_Integration
{
    /**
     * @return \PHPWorkFlow\DB\WorkFlow
     * @throws Exception
     * @throws \PHPWorkFlow\Exception_WorkFlow
     */
    public function testCreateWorkFlow()
    {
        if (!$workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithName('Test Work Flow')) {
            $workFlowObj = $this->getPNMLBusiness()->UploadPNML(PHPWORKFLOW_ARTIFACTS_DIR . '/TestWorkFlow.pnml');
            $this->getTriggerUtil()->GenerateWorkFlowTriggerClass($workFlowObj);
        }
        return $workFlowObj;
    }

    /**
     * @param \PHPWorkFlow\DB\WorkFlow $workFlowObj
     * @depends testCreateWorkFlow
     */
    public function testAddRunThenDeleteFinishedUseCaseWithChildrenCase1(PHPWorkFlow\DB\WorkFlow $workFlowObj)
    {
        $parentUseCaseObj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'      => $workFlowObj->getWorkFlowId(),
                'Name'            => 'Test work flow',
                'Description'     => 'Test work flow',
                'UseCaseStatus'   => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN,
                'UseCaseContexts' => [
                    'key1' => 1,
                    'key2' => 2,
                    'key3' => 3,
                    'key4' => 4,
                    'key5' => 5
                ]
            ]
        );

        $childUseCaseObj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'      => $workFlowObj->getWorkFlowId(),
                'ParentUseCaseId' => $parentUseCaseObj->getUseCaseId(),
                'Name'            => 'Test work flow',
                'Description'     => 'Test work flow',
                'UseCaseStatus'   => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN,
                'UseCaseContexts' => [
                    'key1' => 1,
                    'key2' => 2,
                    'key3' => 3,
                    'key4' => 4,
                    'key5' => 5
                ]
            ]
        );

        /**
         * Make sure they are both open
         */
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $parentUseCaseObj->getUseCaseStatus());
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $childUseCaseObj->getUseCaseStatus());
        $childUseCaseObj = $this->finishTestWorkFlowUseCase($childUseCaseObj);
        /*
         * now only the child should be closed
         */
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::CLOSED, $childUseCaseObj->getUseCaseStatus());
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $parentUseCaseObj->getUseCaseStatus());
        $parentUseCaseObj = $this->finishTestWorkFlowUseCase($parentUseCaseObj);
        /**
         * make sure both closed
         */
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::CLOSED, $childUseCaseObj->getUseCaseStatus());
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::CLOSED, $parentUseCaseObj->getUseCaseStatus());

        $this->getWorkFlowDAO()->DeleteUseCaseWithUseCaseId($parentUseCaseObj->getUseCaseId());
        $this->assertNull($this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($parentUseCaseObj->getUseCaseId()));
        $this->assertNull($this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($childUseCaseObj->getUseCaseId()));
    }

    /**
     * @param \PHPWorkFlow\DB\WorkFlow $workFlowObj
     * @depends testCreateWorkFlow
     */
    public function testAddRunThenDeleteFinishedUseCaseWithChildrenCase2(PHPWorkFlow\DB\WorkFlow $workFlowObj)
    {
        $parentUseCaseObj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'      => $workFlowObj->getWorkFlowId(),
                'Name'            => 'Test work flow',
                'Description'     => 'Test work flow',
                'UseCaseStatus'   => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN,
                'UseCaseContexts' => [
                    'key1' => 1,
                    'key2' => 2,
                    'key3' => 3,
                    'key4' => 4,
                    'key5' => 5
                ]
            ]
        );

        $childUseCaseObj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'      => $workFlowObj->getWorkFlowId(),
                'ParentUseCaseId' => $parentUseCaseObj->getUseCaseId(),
                'Name'            => 'Test work flow',
                'Description'     => 'Test work flow',
                'UseCaseStatus'   => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN,
                'UseCaseContexts' => [
                    'key1' => 1,
                    'key2' => 2,
                    'key3' => 3,
                    'key4' => 4,
                    'key5' => 5
                ]
            ]
        );


        /**
         * Make sure they are both open
         */
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $parentUseCaseObj->getUseCaseStatus());
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $childUseCaseObj->getUseCaseStatus());
        /**
         * Since there are open children, this parent use case should remain open after this
         */
        $parentUseCaseObj = $this->finishTestWorkFlowUseCase($parentUseCaseObj);
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $childUseCaseObj->getUseCaseStatus());
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $parentUseCaseObj->getUseCaseStatus());
        $childUseCaseObj = $this->finishTestWorkFlowUseCase($childUseCaseObj);
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::CLOSED, $childUseCaseObj->getUseCaseStatus());
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $parentUseCaseObj->getUseCaseStatus());

        $workFlowTraffickerObj = new \PHPWorkFlow\WorkFlowTrafficker(null, $parentUseCaseObj->getUseCaseId());
        $workFlowTraffickerObj->checkWorkItemsForCompleteness();
        $parentUseCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($parentUseCaseObj->getUseCaseId());
        $childUseCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($childUseCaseObj->getUseCaseId());

        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::CLOSED, $childUseCaseObj->getUseCaseStatus());
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $parentUseCaseObj->getUseCaseStatus());

        $this->getWorkFlowDAO()->DeleteUseCaseWithUseCaseId($parentUseCaseObj->getUseCaseId());
        $this->assertNull($this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($parentUseCaseObj->getUseCaseId()));
        $this->assertNull($this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($childUseCaseObj->getUseCaseId()));
    }
}