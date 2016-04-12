<?php

namespace PHPWorkFlow;

use PHPWorkFlow\DB\Token;
use PHPWorkFlow\DB\TriggerFulfillment;
use PHPWorkFlow\DB\TriggerFulfillmentQuery;
use PHPWorkFlow\Enum\TriggerFulfillmentStatusEnum;
use PHPWorkFlow\Enum\UseCaseStatusEnum;

/**
 * Class TriggerFulfillmentUtil
 * @package PHPWorkFlow
 * @codeCoverageIgnore
 */
class TriggerFulfillmentUtil
{
    Use WorkFlowDAOTrait;
    Use CommonUtilTrait;

    /**
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function DeleteTriggerFulfillment()
    {
        $triggerFulfillmentObjArr = TriggerFulfillmentQuery::create();
        $triggerFulfillmentObjArr->deleteAll();
    }

    /**
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function DeleteTriggerFulfillmentWithTriggerFulfillmentId($trigger_fulfillment_id)
    {
        return TriggerFulfillmentQuery::create()
            ->filterByTriggerFulfillmentId($trigger_fulfillment_id)
            ->deleteAll();
    }

    /**
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function DeleteTriggerFulfillmentWithUseCaseId($use_case_id)
    {
        return TriggerFulfillmentQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->deleteAll();
    }

    /**
     * @return DB\TriggerFulfillmentQuery[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchTriggerFulfillmentArr()
    {
        return TriggerFulfillmentQuery::create()
            ->find();
    }

    /**
     * @return DB\TriggerFulfillment[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchOpenUseCasesTriggerFulfillmentArr()
    {
        return TriggerFulfillmentQuery::create()
            ->join('TriggerFulfillment.UseCase')
            ->where('UseCase.use_case_status = ?', UseCaseStatusEnum::OPEN)
            ->orderByUseCaseId()
            ->find();
    }

    /**
     * @param $use_case_id
     * @param $transition_trigger_method
     * @return TriggerFulfillment
     */
    public function FetchTriggerFulfillmentWithWorkFlowIdAndUseCaseIdAndTransitionMethodName(
        $work_flow_id,
        $use_case_id,
        $transition_trigger_method
    ) {
        return TriggerFulfillmentQuery::create()
            ->join('TriggerFulfillment.Transition')
            ->where('TriggerFulfillment.use_case_id = ?', $use_case_id)
            ->where('Transition.transition_trigger_method = ?', $transition_trigger_method)
            ->where('Transition.work_flow_id = ?', $work_flow_id)
            ->findOne();
    }

    /**
     * @param $use_case_id
     * @return DB\TriggerFulfillment[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchTriggerFulfillmentArrWithUseCaseId($use_case_id)
    {
        return TriggerFulfillmentQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->find();
    }

    /**
     * @param $use_case_id
     * @return DB\TriggerFulfillment[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchTriggerFulfillmentArrWithUseCaseIdAndTransitionIdAndTriggerFulfillmentStatus(
        $use_case_id,
        $transition_id,
        $trigger_fulfillment_status
    ) {
        return TriggerFulfillmentQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByTransitionId($transition_id)
            ->filterByTriggerFulfillmentStatus($trigger_fulfillment_status)
            ->find()->getData();
    }

    /**
     * @param $use_case_status
     * @return TriggerFulfillment
     */
    public function FetchTriggerFulfillmentArrWithUseCaseStatus($use_case_status)
    {
        return TriggerFulfillmentQuery::create()
            ->join('TriggerFulfillment.UseCase')
            ->where('UseCase.use_case_status = ?', $use_case_status)
            ->find();
    }

    /**
     * @param $use_case_id
     * @param $transition_trigger_name
     * @return TriggerFulfillment
     */
    public function FetchTriggerFulfillmentCountWithUseCaseIdAndTransitionTriggerName(
        $work_flow_id,
        $use_case_id,
        $transition_trigger_name
    ) {
        return TriggerFulfillmentQuery::create()
            ->join('TriggerFulfillment.Transition')
            ->where('Transition.transition_trigger_name = ?', $transition_trigger_name)
            ->where('Transition.work_flow_id = ?', $work_flow_id)
            ->where('TriggerFulfillment.use_case_id = ?', $use_case_id)
            ->count();
    }

    /**
     * @param $properties
     * @return Token
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function CreateTriggerFulfillment($properties)
    {
        if (!isset($properties['TriggerFulfillmentStatus'])) {
            $properties['TriggerFulfillmentStatus'] = TriggerFulfillmentStatusEnum::FREE;
        }
        $triggerFulfillmentObj = new TriggerFulfillment();
        $this->getCommonUtil()->CommonObjectProperties($triggerFulfillmentObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($triggerFulfillmentObj, $properties);
        $triggerFulfillmentObj->save();
        return $triggerFulfillmentObj;
    }

    /**
     * @param       $trigger_fulfillment_id
     * @param array $properties
     * @return int
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function UpdateTriggerFulfillment($trigger_fulfillment_id, array $properties)
    {
        return TriggerFulfillmentQuery::create()
            ->filterByTriggerFulfillmentId($trigger_fulfillment_id)
            ->update($properties);
    }
}
