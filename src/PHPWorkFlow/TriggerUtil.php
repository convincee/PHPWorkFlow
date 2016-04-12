<?php

namespace PHPWorkFlow;

use PHPWorkFlow\Enum\TransitionTypeEnum;

/**
 * Class TriggerUtil
 * @package PHPWorkFlow
 */
class TriggerUtil
{
    use WorkFlowDAOTrait;
    use CommonUtilTrait;

    /**
     * @param DB\WorkFlow $workFlowObj
     * @throws Exception_WorkFlow
     */
    public function GenerateWorkFlowTriggerClass(DB\WorkFlow $workFlowObj)
    {
        $target_location_file = 'Trigger' . $this->getCommonUtil()->CamelCapitalizeFieldName(str_replace(' ', '',
                $workFlowObj->getName())) . '.php';
        if (file_exists(PHPWORKFLOW_TRIGGER_DIR . $target_location_file)) {
            return;
        }
        $smarty = new \Smarty();
        $smarty->setCompileDir('/tmp/');
        $smarty->setTemplateDir(PHPWORKFLOW_SMARTY_TEMPLATE_DIR);
        $smarty->assign(
            'triggerClass',
            'Trigger' . $this->getCommonUtil()->CamelCapitalizeFieldName(str_replace(' ', '', $workFlowObj->getName()), true)
        );
        $transitionsArr = [];
        $transitionObjArr = $workFlowObj->getTransitions();
        foreach ($transitionObjArr as $transitionObj) {
            if ($transitionObj->getTransitionType() == TransitionTypeEnum::EMITTER) {
                continue;
            }
            if ($transitionObj->getTransitionType() == TransitionTypeEnum::CONSUMER) {
                continue;
            }
            /*
             * putting this into hashed array for room to grow
             */
            $transitionsArr[] = [
                'triggerName'    => $this->getCommonUtil()->CamelCapitalizeFieldName($transitionObj->getName() . 'Trigger' . ucfirst($transitionObj->getTransitionType())),
                'transitionType' => $transitionObj->getTransitionType(),
                'time_delay'     => $transitionObj->getTimeDelay()
            ];
        }
        $smarty->assign('triggerClassArr', $transitionsArr);

        $this->writeClassFile(
            PHPWORKFLOW_TRIGGER_DIR,
            $target_location_file,
            $smarty->fetch('WorkFlowTriggerClass.tpl')
        );
    }

    /**
     * @param $outputTarget
     * @param $class_name
     * @param $content
     * @throws \PHPWorkFlow\Exception_WorkFlow
     */
    private function writeClassFile($outputTarget, $class_name, $content)
    {
        /**
         * first, let's make sure that directory $outputTarget is there
         */
        if (!file_exists($outputTarget)) {
            $cmd = 'mkdir -p ' . $outputTarget;
            exec($cmd, $returnOutput);

            if (!file_exists($outputTarget)) {
                exit(0);
            }
        }
        if (!$fh = fopen($outputTarget . $class_name, "w")) {
            throw new Exception_WorkFlow("failed to open " . $outputTarget . $class_name);
        };
        fputs($fh, $content);
        fclose($fh);
    }

}
