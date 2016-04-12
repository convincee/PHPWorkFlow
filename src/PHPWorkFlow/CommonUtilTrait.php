<?php

namespace PHPWorkFlow;

/**
 * Class CommonUtilTrait
 * @package PHPTriggerFulfillment
 * @codeCoverageIgnore
 */
trait CommonUtilTrait
{
    protected $CommonUtil = null;

    /**
     * @return CommonUtil
     */
    function getCommonUtil()
    {
        if(! $this->CommonUtil)
        {
            $this->setCommonUtil(new CommonUtil());
        }
        return $this->CommonUtil;
    }

    /**
     * @param $CommonUtil CommonUtil
     */
    function setCommonUtil($CommonUtil)
    {
        $this->CommonUtil = $CommonUtil;
    }
}
