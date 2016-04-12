<?php

namespace PHPWorkFlow;

/**
 * Class WorkFlowDAOTrait
 * @package PHPWorkFlow
 * @codeCoverageIgnore
 */
trait WorkFlowDAOTrait
{
    protected $WorkFlowDAO = null;

    /**
     * @return WorkFlowDAO
     */
    function getWorkFlowDAO()
    {
        if(! $this->WorkFlowDAO)
        {
            $this->setWorkFlowDAO(new WorkFlowDAO());
        }
        return $this->WorkFlowDAO;
    }

    /**
     * @param $WorkFlowDAO WorkFlowDAO
     */
    function setWorkFlowDAO($WorkFlowDAO)
    {
        $this->WorkFlowDAO = $WorkFlowDAO;
    }
}
