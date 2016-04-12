<?php

namespace PHPWorkFlow\DB;

use PHPWorkFlow\DB\Base\WorkFlow as BaseWorkFlow;
use Propel\Runtime\Map\TableMap;

/**
 * Skeleton subclass for representing a row from the 'PHPWF_work_flow' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class WorkFlow extends BaseWorkFlow
{
    use \PHPWorkFlow\WorkFlowDAOTrait;
    /**
     * @return Place
     */
    public function getEndPlace()
    {
        return $this->getWorkFlowDAO()->FetchEndPlaceWithWorkFlowId($this->getWorkFlowId());
    }
    /**
     * @return Place
     */
    public function getStartPlace()
    {
        return $this->getWorkFlowDAO()->FetchStartPlaceWithWorkFlowId($this->getWorkFlowId());
    }

    /**
     * @param string $keyType
     * @param bool   $includeLazyLoadColumns
     * @param array  $alreadyDumpedObjects
     * @param bool   $includeForeignObjects
     * @return array
     */
    public function toArray(
        $keyType = TableMap::TYPE_PHPNAME,
        $includeLazyLoadColumns = true,
        $alreadyDumpedObjects = [],
        $includeForeignObjects = false
    ) {
        $workflow_arr = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects,
            $includeForeignObjects);
        $workflow_arr['arc_arr'] = [];
        foreach ($this->getWorkFlowDAO()->FetchArcArrWithWorkFlowId($this->getWorkFlowId()) as $arcObj) {
            $workflow_arr['arc_arr'][] = $arcObj->toArray();
        }
        $workflow_arr['transition_arr'] = [];
        foreach ($this->getWorkFlowDAO()->FetchTransitionArrWithWorkFlowId($this->getWorkFlowId()) as $transitionObj) {
            $workflow_arr['transition_arr'][] = $transitionObj->toArray();
        }
        $workflow_arr['place_arr'] = [];
        foreach ($this->getWorkFlowDAO()->FetchPlaceArrWithWorkFlowId($this->getWorkFlowId()) as $placeObj) {
            $workflow_arr['place_arr'][] = $placeObj->toArray();
        }
        return $workflow_arr;
    }

}
