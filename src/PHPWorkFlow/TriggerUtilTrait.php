<?php

namespace PHPWorkFlow;

/**
 * Class TriggerTrait
 * @package PHPWorkFlow
 * @codeCoverageIgnore
 */
trait TriggerUtilTrait
{
    protected $TriggerUtil = null;

    /**
     * @return TriggerUtil
     */
    function getTriggerUtil()
    {
        if(! $this->TriggerUtil)
        {
            $this->setTriggerUtil(new TriggerUtil());
        }
        return $this->TriggerUtil;
    }

    /**
     * @param $TriggerUtil TriggerUtil
     */
    function setTriggerUtil($TriggerUtil)
    {
        $this->TriggerUtil = $TriggerUtil;
    }
}
