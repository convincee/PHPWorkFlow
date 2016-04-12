<?php

namespace PHPWorkFlow\DB;

use PHPWorkFlow\DB\Base\Token as BaseToken;
use Propel\Runtime\Map\TableMap;

/**
 * Skeleton subclass for representing a row from the 'PHPWF_token' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Token extends BaseToken
{
    use \PHPWorkFlow\WorkFlowDAOTrait;

    /**
     * @return array|mixed|WorkItem[]|\Propel\Runtime\ActiveRecord\ActiveRecordInterface[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function GetInboundWorkItems()
    {
        return $this->getWorkFlowDAO()->FetchInwardWorkItemsWithUseCaseIdAndPlaceId($this->getUseCaseId(), $this->getPlaceId());
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
        $token_arr = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects,
            $includeForeignObjects);
        $token_arr['Place'] = $this->getWorkFlowDAO()->FetchPlaceWithPlaceId($this->getPlaceId())->toArray();
        if($this->getCreatingWorkItemId())
        {
            $token_arr['CreatingWorkItem'] = $this->getWorkFlowDAO()->FetchWorkItemWithWorkItemId($this->getCreatingWorkItemId())->toArray();
        }
        if($this->getConsumingWorkItemId())
        {
            $token_arr['ConsumingWorkItem'] = $this->getWorkFlowDAO()->FetchWorkItemWithWorkItemId($this->getConsumingWorkItemId())->toArray();
        }

        return $token_arr;
    }
}
