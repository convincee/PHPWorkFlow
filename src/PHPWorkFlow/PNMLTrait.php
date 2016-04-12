<?php

namespace PHPWorkFlow;

/**
 * Class PNMLTrait
 * @package PHPWorkFlow
 */
trait PNMLTrait
{
    protected $PNMLBusiness = null;

    /**
     * @return PNML
     */
    function getPNMLBusiness()
    {
        if(! $this->PNMLBusiness)
        {
            $this->setPNMLBusiness(new PNML());
        }
        return $this->PNMLBusiness;
    }

    /**
     * @param $PNMLBusiness PNML
     */
    function setPNMLBusiness(PNML $PNMLBusiness)
    {
        $this->PNMLBusiness = $PNMLBusiness;
    }
}
