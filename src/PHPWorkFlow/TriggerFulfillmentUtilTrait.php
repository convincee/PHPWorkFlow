<?php

namespace PHPWorkFlow;

/**
 * Class TriggerFulfillmentTrait
 * @package PHPTriggerFulfillment
 * @codeCoverageIgnore
 */
trait TriggerFulfillmentUtilTrait
{
    protected $TriggerFulfillmentUtil = null;

    /**
     * @return TriggerFulfillmentUtil
     */
    function getTriggerFulfillmentUtil()
    {
        if(! $this->TriggerFulfillmentUtil)
        {
            $this->setTriggerFulfillmentUtil(new TriggerFulfillmentUtil());
        }
        return $this->TriggerFulfillmentUtil;
    }

    /**
     * @param $TriggerFulfillmentUtil TriggerFulfillmentUtil
     */
    function setTriggerFulfillmentUtil($TriggerFulfillmentUtil)
    {
        $this->TriggerFulfillmentUtil = $TriggerFulfillmentUtil;
    }
}
