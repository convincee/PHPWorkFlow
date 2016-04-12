<?php

namespace PHPWorkFlow\DB;

use PHPWorkFlow\DB\Base\Transition as BaseTransition;

/**
 * Skeleton subclass for representing a row from the 'PHPWF_transition' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Transition extends BaseTransition
{
    use \PHPWorkFlow\WorkFlowDAOTrait;

    /**
     * @return Arc[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getInwardArcArr()
    {
        return $this->getWorkFlowDAO()->FetchInwardArcArrWithTransitionId($this->getTransitionId());
    }
}
