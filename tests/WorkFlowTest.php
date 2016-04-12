<?php

require_once __DIR__ . '/../PHPWorkFlow.init.php';

/**
 * Class WorkFlowTest
 *
 * @backupGlobals          disabled
 * @backupStaticAttributes disabled
 * @codeCoverageIgnore
 */
class WorkFlowTest extends PHPWorkFlow_Framework_TestCase_Integration
{
    /**
     * @return \PHPWorkFlow\DB\WorkFlow
     * @throws Exception
     * @throws \PHPWorkFlow\Exception_WorkFlow
     */
    public function testCreateWorkFlow()
    {
        if ($workFlowObj = $this->getWorkFlowDAO()->FetchWorkFlowWithName('Test Work Flow')) {
            $this->getWorkFlowDAO()->DeleteWorkFlowWithWorkFlowId($workFlowObj->getWorkFlowId());
            $trigger_file = PHPWORKFLOW_TRIGGER_DIR . '/TriggerTestWorkFlow.php';
            if (file_exists($trigger_file)) {
                unlink($trigger_file);
            }
        }

        $workFlowObj = $this->getPNMLBusiness()->UploadPNML(PHPWORKFLOW_ARTIFACTS_DIR . '/TestWorkFlow.pnml');
        $this->getTriggerUtil()->GenerateWorkFlowTriggerClass($workFlowObj);
        $this->saveOffPnml($workFlowObj, null, 0, __FUNCTION__);

        /**
         * ensure that a generated pnml exactly matches it's origional
         */
        $work_flow_xml = $this->getPNMLBusiness()->GeneratePNML($workFlowObj->getWorkFlowId());
        $pnmlFileContents = file_get_contents(PHPWORKFLOW_ARTIFACTS_DIR . '/TestWorkFlow.pnml');
        $origionalRootElement = new \SimpleXMLElement($pnmlFileContents);
        $generatedRootElement = new \SimpleXMLElement($work_flow_xml);
        $this->assertEquals($origionalRootElement->saveXML(), $generatedRootElement->saveXML());

        $this->assertEquals(
            33,
            count($this->getWorkFlowDAO()->FetchTransitionArrWithWorkFlowId($workFlowObj->getWorkFlowId()))
        );
        $this->assertEquals(
            75,
            count($this->getWorkFlowDAO()->FetchArcArrWithWorkFlowId($workFlowObj->getWorkFlowId()))
        );
        $this->assertEquals(
            34,
            count($this->getWorkFlowDAO()->FetchPlaceArrWithWorkFlowId($workFlowObj->getWorkFlowId()))
        );
        $this->assertEquals(
            30,
            count($this->getWorkFlowDAO()->FetchRouteArrWithWorkFlowId($workFlowObj->getWorkFlowId()))
        );
        $this->assertEquals(
            4,
            count($this->getWorkFlowDAO()->FetchNotificationArrWithWorkFlowId($workFlowObj->getWorkFlowId()))
        );
        $this->assertEquals(
            2,
            count($this->getWorkFlowDAO()->FetchGateArrWithWorkFlowId($workFlowObj->getWorkFlowId()))
        );

        $this->assertEquals(
            1,
            count($this->getWorkFlowDAO()->FetchTransitionArrWithWorkFlowIdAndTransitionType(
                $workFlowObj->getWorkFlowId(),
                \PHPWorkFlow\Enum\TransitionTypeEnum::TIMED)
            )
        );
        $this->assertEquals(
            21,
            count($this->getWorkFlowDAO()->FetchTransitionArrWithWorkFlowIdAndTransitionType(
                $workFlowObj->getWorkFlowId(),
                \PHPWorkFlow\Enum\TransitionTypeEnum::USER)
            )
        );
        $this->assertEquals(
            6,
            count($this->getWorkFlowDAO()->FetchTransitionArrWithWorkFlowIdAndTransitionType(
                $workFlowObj->getWorkFlowId(),
                \PHPWorkFlow\Enum\TransitionTypeEnum::AUTO)
            ));
        $this->assertEquals(
            1,
            count($this->getWorkFlowDAO()->FetchTransitionArrWithWorkFlowIdAndTransitionType(
                $workFlowObj->getWorkFlowId(),
                \PHPWorkFlow\Enum\TransitionTypeEnum::EMITTER)
            )
        );
        $this->assertEquals(
            1,
            count($this->getWorkFlowDAO()->FetchTransitionArrWithWorkFlowIdAndTransitionType(
                $workFlowObj->getWorkFlowId(),
                \PHPWorkFlow\Enum\TransitionTypeEnum::CONSUMER)
            )
        );
        $this->assertEquals(
            1,
            count($this->getWorkFlowDAO()->FetchTransitionArrWithWorkFlowIdAndTransitionType(
                $workFlowObj->getWorkFlowId(),
                \PHPWorkFlow\Enum\TransitionTypeEnum::GATE)
            )
        );
        $this->assertEquals(
            2,
            count($this->getWorkFlowDAO()->FetchTransitionArrWithWorkFlowIdAndTransitionType(
                $workFlowObj->getWorkFlowId(),
                \PHPWorkFlow\Enum\TransitionTypeEnum::NOTIFICATION)
            )
        );

        $this->assertEquals(
            'PHPWorkFlow\DB\Transition',
            get_class($transitionObj = $this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndName(
                $workFlowObj->getWorkFlowId(),
                'TR20 Create Build User Config'
            ))
        );
        /**
         * Routes
         */
        $this->assertEquals(
            2,
            count($this->getWorkFlowDAO()->FetchRouteArrWithWorkFlowIdAndTransitionId(
                $workFlowObj->getWorkFlowId(),
                $transitionObj->getTransitionId()
            ))
        );
        $this->assertEquals(
            'PHPWorkFlow\DB\Route',
            get_class($this->getWorkFlowDAO()->FetchRouteWithWorkFlowIdAndRoute(
                $workFlowObj->getWorkFlowId(),
                '/example_tr20'
            ))
        );

        /**
         * Notifications
         */
        $this->assertEquals(
            'PHPWorkFlow\DB\Transition',
            get_class($transitionObj = $this->getWorkFlowDAO()->FetchTransitionWithWorkFlowIdAndName(
                $workFlowObj->getWorkFlowId(),
                'TR12 Email Super'
            ))
        );
        $this->assertEquals(
            2,
            count($this->getWorkFlowDAO()->FetchNotificationsArrWithTransitionId(
                $transitionObj->getTransitionId()
            ))
        );
        $this->assertEquals(
            2,
            count($transitionObj->getNotifications())
        );
        return $workFlowObj;
    }
}