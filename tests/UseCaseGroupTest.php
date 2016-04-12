<?php

require_once __DIR__ . '/../PHPWorkFlow.init.php';

/**
 * Class WorkFlowTest
 *
 * @backupGlobals          disabled
 * @backupStaticAttributes disabled
 * @codeCoverageIgnore
 */
class UseCaseGroupTest extends PHPWorkFlow_Framework_TestCase_Integration
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
        $some_big_random_number = uniqid();
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

        $childUseCase1Obj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'      => $workFlowObj->getWorkFlowId(),
                'ParentUseCaseId' => $parentUseCaseObj->getUseCaseId(),
                'Name'            => 'Test work flow',
                'Description'     => 'Test work flow',
                'UseCaseStatus'   => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN,
                'UseCaseGroup'    => $some_big_random_number,
                'UseCaseContexts' => [
                    'key1' => 1,
                    'key2' => 2,
                    'key3' => 3,
                    'key4' => 4,
                    'key5' => 5
                ]
            ]
        );


        $childUseCase2Obj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'      => $workFlowObj->getWorkFlowId(),
                'ParentUseCaseId' => $parentUseCaseObj->getUseCaseId(),
                'Name'            => 'Test work flow',
                'Description'     => 'Test work flow',
                'UseCaseStatus'   => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN,
                'UseCaseGroup'    => $some_big_random_number,
                'UseCaseContexts' => [
                    'key1' => 1,
                    'key2' => 2,
                    'key3' => 3,
                    'key4' => 4,
                    'key5' => 5
                ]
            ]
        );


        $childUseCase3Obj = $this->getWorkFlowDAO()->CreateUseCase(
            [
                'WorkFlowId'      => $workFlowObj->getWorkFlowId(),
                'ParentUseCaseId' => $parentUseCaseObj->getUseCaseId(),
                'Name'            => 'Test work flow',
                'Description'     => 'Test work flow',
                'UseCaseStatus'   => \PHPWorkFlow\Enum\UseCaseStatusEnum::OPEN,
                'UseCaseGroup'    => $some_big_random_number,
                'UseCaseContexts' => [
                    'key1' => 1,
                    'key2' => 2,
                    'key3' => 3,
                    'key4' => 4,
                    'key5' => 5
                ]
            ]
        );

        $childUseCaseObjArr = $parentUseCaseObj->getChildern();
        $this->assertEquals(3, count($childUseCaseObjArr));
        foreach($childUseCaseObjArr as $childUseCaseObj) {
            $this->assertEquals('PHPWorkFlow\DB\UseCase', get_class($childUseCaseObj));
            $this->assertEquals($parentUseCaseObj->getUseCaseId(), $childUseCaseObj->getParentUseCaseId());
            $this->assertEquals($childUseCaseObj->getUseCaseGroup(),$some_big_random_number);
        }
    }
}