<?php

require_once __DIR__.'/../PHPWorkFlow.init.php';

/**
 * Class WorkFlowTest
 *
 * @backupGlobals          disabled
 * @backupStaticAttributes disabled
 * @codeCoverageIgnore
 */
class UseCaseTest extends PHPWorkFlow_Framework_TestCase_Integration
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
     * @param \PHPWorkFlow\DB\WorkFlow $workFlowObj
     * @depends testCreateWorkFlow
     */
    public function testAddThenDeleteUnFinishedUseCase(PHPWorkFlow\DB\WorkFlow $workFlowObj)
    {
        $use_case_rec_count = $this->getWorkFlowDAO()->FetchUseCaseCount();
        $token_rec_count = $this->getWorkFlowDAO()->FetchTokenCount();
        $work_item_count = $this->getWorkFlowDAO()->FetchWorkItemCount();
        $use_case_contest_count = $this->getWorkFlowDAO()->FetchUseCaseContextCount();

        $useCaseObj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'    => $workFlowObj->getWorkFlowId(),
                'Name'          => 'Test work flow',
                'Description'   => 'Test work flow',
                'UseCaseStatus' => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN,
                'UseCaseContexts' => [
                    'key1' => 1,
                    'key2' => 2,
                    'key3' => 3,
                    'key4' => 4,
                    'key5' => 5
                ]
            ]
        );

        $useCaseContextObj = $this->getWorkFlowDAO()->FetchUseCaseContextArrWithUseCaseIdAndName(
            $useCaseObj->getUseCaseId(), 'key1'
        );
        $this->assertEquals(1, $useCaseContextObj->getValue());

        $this->getWorkFlowDAO()->DeleteUseCaseWithUseCaseId($useCaseObj->getUseCaseId());
        $this->assertEquals($use_case_rec_count, $this->getWorkFlowDAO()->FetchUseCaseCount());
        $this->assertEquals($token_rec_count, $this->getWorkFlowDAO()->FetchTokenCount());
        $this->assertEquals($work_item_count, $this->getWorkFlowDAO()->FetchWorkItemCount());
        $this->assertEquals($use_case_contest_count, $this->getWorkFlowDAO()->FetchUseCaseContextCount());
    }

    /**
     * @param \PHPWorkFlow\DB\WorkFlow $workFlowObj
     * @depends testCreateWorkFlow
     */
    public function testAddThenDeleteFinishedUseCase(PHPWorkFlow\DB\WorkFlow $workFlowObj)
    {
        $use_case_rec_count = $this->getWorkFlowDAO()->FetchUseCaseCount();
        $token_rec_count = $this->getWorkFlowDAO()->FetchTokenCount();
        $work_item_count = $this->getWorkFlowDAO()->FetchWorkItemCount();
        $use_case_contest_count = $this->getWorkFlowDAO()->FetchUseCaseContextCount();

        $useCaseObj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'    => $workFlowObj->getWorkFlowId(),
                'Name'          => 'Test work flow',
                'Description'   => 'Test work flow',
                'UseCaseStatus' => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN,
                'UseCaseContexts' => [
                    'key1' => 1,
                    'key2' => 2,
                    'key3' => 3,
                    'key4' => 4,
                    'key5' => 5
                ]
            ]
        );

        $useCaseContextObj = $this->getWorkFlowDAO()->FetchUseCaseContextArrWithUseCaseIdAndName(
            $useCaseObj->getUseCaseId(), 'key1'
        );
        $this->assertEquals(1, $useCaseContextObj->getValue());

        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $useCaseObj->getUseCaseStatus());
        $this->finishTestWorkFlowUseCase($useCaseObj);
        $useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($useCaseObj->getUseCaseId());
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::CLOSED, $useCaseObj->getUseCaseStatus());

        $this->getWorkFlowDAO()->DeleteUseCaseWithUseCaseId($useCaseObj->getUseCaseId());
        $this->assertEquals($use_case_rec_count, $this->getWorkFlowDAO()->FetchUseCaseCount());
        $this->assertEquals($token_rec_count, $this->getWorkFlowDAO()->FetchTokenCount());
        $this->assertEquals($work_item_count, $this->getWorkFlowDAO()->FetchWorkItemCount());
        $this->assertEquals($use_case_contest_count, $this->getWorkFlowDAO()->FetchUseCaseContextCount());

    }

    /**
     * @param \PHPWorkFlow\DB\WorkFlow $workFlowObj
     * @depends testCreateWorkFlow
     * @todo need much more unit testing and functionality re: UseCaseContext
     */
    public function testUseCaseContext(PHPWorkFlow\DB\WorkFlow $workFlowObj)
    {
        $some_big_random_number = uniqid('', false);
        $another_big_random_number = uniqid('', false);
        $useCaseObj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'    => $workFlowObj->getWorkFlowId(),
                'Name'          => 'Test work flow',
                'Description'   => 'Test work flow',
                'UseCaseStatus' => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN,
                'UseCaseContexts' => [
                    'key1' => 1,
                    'key2' => 2,
                    'key3' => 3,
                    'key4' => 4,
                    'key5' => 5
                ]
            ]
        );
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN, $useCaseObj->getUseCaseStatus());
        $useCaseObj = $this->finishTestWorkFlowUseCase($useCaseObj);
        $this->assertEquals(\PHPWorkFlow\Enum\UseCaseStatusEnum::CLOSED, $useCaseObj->getUseCaseStatus());
    }
}