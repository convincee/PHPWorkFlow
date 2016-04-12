<?php

namespace PHPWorkFlow\DB;

use PHPWorkFlow\DB\Base\WorkItem as BaseWorkItem;
use Propel\Runtime\Map\TableMap;

/**
 * Skeleton subclass for representing a row from the 'PHPWF_work_item' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class WorkItem extends BaseWorkItem
{
    use \PHPWorkFlow\WorkFlowDAOTrait;

    /**
     * @return Token[]
     */
    public function getInboundTokenArr()
    {
        return $this->getWorkFlowDAO()->FetchInboundTokensWithWorkItemIdArr($this->getUseCaseId(),
            $this->getWorkItemId());
    }

    /**
     * @return Token[]
     */
    public function getFreeInboundTokenArr()
    {
        return $this->getWorkFlowDAO()->FetchFreeInboundTokensWithWorkItemIdArr($this->getUseCaseId(),
            $this->getWorkItemId());
    }

    /**
     * @return array|mixed|Place[]|\Propel\Runtime\ActiveRecord\ActiveRecordInterface[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getInboundPlaceArr()
    {
        return $this->getWorkFlowDAO()->FetchInboundPlacesWithWorkItemIdArr($this->getWorkItemId());
    }

    /**
     * @return array|mixed|Place[]|\Propel\Runtime\ActiveRecord\ActiveRecordInterface[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getOutboundPlaceArr()
    {
        return $this->getWorkFlowDAO()->FetchOutboundPlacesWithWorkItemIdArr($this->getWorkItemId());
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
        $workitem_arr = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects,
            $includeForeignObjects);
        $workitem_arr['Transition'] = $this->getWorkFlowDAO()->FetchTransitionWithTransitionId($this->getTransitionId())->toArray();
        return $workitem_arr;
    }
}
