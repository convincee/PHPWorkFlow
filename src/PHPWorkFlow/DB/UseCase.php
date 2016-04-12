<?php

namespace PHPWorkFlow\DB;

use PHPWorkFlow\DB\Base\UseCase as BaseUseCase;
use Propel\Runtime\Map\TableMap;

/**
 * Skeleton subclass for representing a row from the 'PHPWF_use_case' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class UseCase extends BaseUseCase
{
    use \PHPWorkFlow\WorkFlowDAOTrait;

    /**
     * @return WorkItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getEnabledWorkItemArr()
    {
        return $this->getWorkFlowDAO()->FetchEnabledWorkItemArrWithUseCaseId($this->getUseCaseId());
    }

    /**
     * @return WorkItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getEnabledWorkItemCount()
    {
        return $this->getWorkFlowDAO()->FetchEnabledWorkItemWithUseCaseIdCount($this->getUseCaseId());
    }

    /**
     * @return Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getFreeTokenArr()
    {
        return $this->getWorkFlowDAO()->FetchFreeTokenWithUseCaseIdArr($this->getUseCaseId());
    }

    /**
     * @return Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getFreeTokenCount()
    {
        return $this->getWorkFlowDAO()->FetchFreeTokenWithUseCaseIdCount($this->getUseCaseId());
    }

    /**
     * @param $transition_trigger_method
     * @return Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function getEnabledWorkItemArrWithTransitionTriggerMethod($transition_trigger_method)
    {
        return $this->getWorkFlowDAO()->FetchEnabledWorkItemArrWithUseCaseIdAndTransitionTriggerMethod(
            $this->getUseCaseId(),
            $transition_trigger_method
        );
    }

    /**
     * @return UseCase[]
     */
    public function getChildern()
    {
        return $this->getWorkFlowDAO()->FetchChildrenWithParentUseCaseId($this->getUseCaseId());
    }

    /**
     * @return UseCase[]
     */
    public function getOpenChildern()
    {
        return $this->getWorkFlowDAO()->FetchOpenChildrenWithParentUseCaseId($this->getUseCaseId());
    }

    /**
     * @return UseCase[]
     */
    public function getOpenChildernInGroup($use_case_group)
    {
        return $this->getWorkFlowDAO()->FetchOpenChildrenWithParentUseCaseIdAndUseCaseGroup($this->getUseCaseId(),
            $use_case_group);
    }

    /**
     * @return bool
     */
    public function numOpenChildren()
    {
        return count($this->getOpenChildern());
    }

    /**
     * @param string     $keyType
     * @param bool|true  $includeLazyLoadColumns
     * @param array      $alreadyDumpedObjects
     * @param bool|false $includeForeignObjects
     * @return array
     */
    public function toArray(
        $keyType = TableMap::TYPE_PHPNAME,
        $includeLazyLoadColumns = true,
        $alreadyDumpedObjects = [],
        $includeForeignObjects = false
    ) {
        $usecase_arr = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects,
            $includeForeignObjects);
        $usecase_arr['token_arr'] = [];
        foreach ($this->getWorkFlowDAO()->FetchTokenArrWithUseCaseId($this->getUseCaseId()) as $tokenObj) {
            $usecase_arr['token_arr'][] = $tokenObj->toArray();
        }
        $usecase_arr['work_item_arr'] = [];
        foreach ($this->getWorkFlowDAO()->FetchWorkItemArrWithUseCaseIdArr($this->getUseCaseId()) as $workItemObj) {
            $usecase_arr['work_item_arr'][] = $workItemObj->toArray();
        }
        return $usecase_arr;
    }
}
