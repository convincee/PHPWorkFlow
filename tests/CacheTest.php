<?php

require_once __DIR__.'/../PHPWorkFlow.init.php';

/**
 * Class WorkFlowTest
 *
 * @backupGlobals          disabled
 * @backupStaticAttributes disabled
 * @codeCoverageIgnore
 */
class CacheTest extends PHPWorkFlow_Framework_TestCase_Integration
{
    /**
     * @return \PHPWorkFlow\DB\WorkFlow
     * @throws Exception
     * @throws \PHPWorkFlow\Exception_WorkFlow
     */
    public function testFetchWorkFlowWithWorkFlowId()
    {
        if(! $workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithName('Test Work Flow'))
        {
            $workFlowObj = $this->getPNMLBusiness()->UploadPNML(PHPWORKFLOW_ARTIFACTS_DIR . '/TestWorkFlow.pnml');
            $this->getTriggerUtil()->GenerateWorkFlowTriggerClass($workFlowObj);
        }

        $workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithWorkFlowId($workFlowObj->getWorkFlowId());
        $this->assertEquals('PHPWorkFlow\DB\WorkFlow', get_class($workFlowObj));

        $workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithWorkFlowId($workFlowObj->getWorkFlowId());
        $this->assertEquals('PHPWorkFlow\DB\WorkFlow', get_class($workFlowObj));
    }
}