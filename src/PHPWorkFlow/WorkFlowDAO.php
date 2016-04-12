<?php

namespace PHPWorkFlow;

use PHPWorkFlow\DB\Arc;
use PHPWorkFlow\DB\ArcQuery;
use PHPWorkFlow\DB\WorkFlowQuery;
use PHPWorkFlow\DB\WorkFlow;
use PHPWorkFlow\DB\Place;
use PHPWorkFlow\DB\PlaceQuery;
use PHPWorkFlow\DB\Transition;
use PHPWorkFlow\DB\TransitionQuery;
use PHPWorkFlow\DB\WorkItem;
use PHPWorkFlow\DB\WorkItemQuery;
use PHPWorkFlow\DB\UseCase;
use PHPWorkFlow\DB\UseCaseQuery;
use PHPWorkFlow\DB\Token;
use PHPWorkFlow\DB\TokenQuery;
use PHPWorkFlow\DB\Route;
use PHPWorkFlow\DB\RouteQuery;
use PHPWorkFlow\DB\Notification;
use PHPWorkFlow\DB\NotificationQuery;
use PHPWorkFlow\DB\Gate;
use PHPWorkFlow\DB\GateQuery;
use PHPWorkFlow\DB\Command;
use PHPWorkFlow\DB\CommandQuery;
use PHPWorkFlow\DB\UseCaseContext;
use PHPWorkFlow\DB\UseCaseContextQuery;
use PHPWorkFlow\Enum\TokenStatusEnum;
use PHPWorkFlow\Enum\TransitionTypeEnum;
use PHPWorkFlow\Enum\UseCaseStatusEnum;
use PHPWorkFlow\Enum\WorkItemStatusEnum;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Propel;

/**
 * Class WorkFlowDAO
 * @package PHPWorkFlow
 */
class WorkFlowDAO
{
    use CommonUtilTrait;
    /**
     * @param Token $tokenObj
     * @return array|mixed|DB\WorkItem[]|\Propel\Runtime\ActiveRecord\ActiveRecordInterface[]|\Propel\Runtime\Collection\ObjectCollection
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function FetchInwardWorkItemsWithUseCaseIdAndPlaceId($use_case_id, $place_id)
    {
        return WorkItemQuery::create()
            ->join('WorkItem.Arc')
            ->where('Arc.direction = ?', 'IN')
            ->where('Arc.place_id = ?', $place_id)
            ->where('WorkItem.use_case_id = ?', $use_case_id)
            ->where('WorkItem.work_item_status = ?', WorkItemStatusEnum::ENABLED)
            ->find()->getData();
    }

    /**
     * @return DB\WorkFlow[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchWorkFlowArr()
    {
        return WorkFlowQuery::create()
            ->orderByWorkFlowId()
            ->find()->getData();
    }

    /**
     * @return DB\UseCase[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchUseCaseArr()
    {
        return UseCaseQuery::create()
            ->orderByUseCaseId()
            ->find()->getData();
    }

    /**
     * @param $use_case_status
     * @return DB\UseCase[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchUseCaseArrWithUseCaseStatus($use_case_status)
    {
        $UseCaseQuery = UseCaseQuery::create();
        if ($use_case_status) {
            $UseCaseQuery->filterByUseCaseStatus($use_case_status);
        }
        return $UseCaseQuery->orderByUseCaseId()
            ->find()->getData();
    }

    /**
     * @param $use_case_id
     * @param $name
     * @return UseCaseContext
     */
    public function FetchUseCaseContextArrWithUseCaseIdAndName($use_case_id, $name)
    {
        return UseCaseContextQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByName($name)
            ->findOne();
    }

    /**
     * @return DB\WorkItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchWorkItemArr()
    {
        return WorkItemQuery::create()
            ->find()->getData();
    }

    /**
     * @param array $properties
     * @return DB\WorkFlow
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function CreateWorkFlow(array $properties)
    {
        if (!isset($properties['Description'])) {
            $properties['Description'] = $properties['Name'];
        }
        return NeverWrongCacheUtil::GenericCacheWrapperInsertUpdateDelete(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow'],
            function($properties){
                $workFlowObj = new WorkFlow();
                $this->getCommonUtil()->CommonObjectProperties($workFlowObj);
                $this->getCommonUtil()->PopulateObjectWithProperties($workFlowObj, $properties);
                $workFlowObj->save();
                return $workFlowObj;
            }
        );
    }

    /**
     * @param  $properties array
     * @return Place
     */
    public function CreatePlace(array $properties)
    {
        if (!isset($properties['Description'])) {
            $properties['Description'] = $properties['Name'];
        }
        $placeFlowObj = new Place();
        $this->getCommonUtil()->CommonObjectProperties($placeFlowObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($placeFlowObj, $properties);
        $placeFlowObj->save();
        return $placeFlowObj;
    }

    /**
     * @param  $properties array
     * @return Place
     */
    public function CreateUseCaseContext(array $properties)
    {
        if (!isset($properties['Description'])) {
            $properties['Description'] = $properties['Name'];
        }
        $useCaseContextObj = new UseCaseContext();
        $this->getCommonUtil()->CommonObjectProperties($useCaseContextObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($useCaseContextObj, $properties);
        $useCaseContextObj->save();
        return $useCaseContextObj;
    }

    /**
     * @param  $properties array
     * @return Arc[]
     */
    public function CreateArc(array $properties)
    {
        if (!isset($properties['Description'])) {
            $properties['Description'] = $properties['Name'];
        }
        $arcFlowObj = new Arc();
        $this->getCommonUtil()->CommonObjectProperties($arcFlowObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($arcFlowObj, $properties);
        $arcFlowObj->save();
        return $arcFlowObj;
    }

    /**
     * @param  $properties array
     * @return Transition
     */
    public function CreateTransition(array $properties)
    {
        if (!isset($properties['TriggerAction'])) {
            $properties['TransitionTriggerMethod'] = $this->getCommonUtil()->CamelCapitalizeFieldName(
                    $properties['Name'],
                    true
                ) . 'Trigger' . ucfirst($properties['TransitionType']);
        }
        if (!isset($properties['Description'])) {
            $properties['Description'] = '{}';
        }
        if (!isset($properties['TimeDelay'])) {
            $properties['TimeDelay'] = null;
        }
        if (!isset($properties['YasperName'])) {
            $properties['YasperName'] = $properties['Name'];
        }
        $transitionFlowObj = new Transition();
        $this->getCommonUtil()->CommonObjectProperties($transitionFlowObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($transitionFlowObj, $properties);
        $transitionFlowObj->save();
        return $transitionFlowObj;
    }

    /**
     * @param array $properties
     * @return Route
     */
    public function CreateRoute(array $properties)
    {
        $routeObj = new Route();
        $this->getCommonUtil()->CommonObjectProperties($routeObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($routeObj, $properties);

        $routeObj->save();
        return $routeObj;
    }

    /**
     * @param array $properties
     * @return Route
     */
    public function CreateNotification(array $properties)
    {
        $notificationObj = new Notification();
        $this->getCommonUtil()->CommonObjectProperties($notificationObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($notificationObj, $properties);

        $notificationObj->save();
        return $notificationObj;
    }

    /**
     * @param array $properties
     * @return Command
     */
    public function CreateCommand(array $properties)
    {
        $commandObj = new Command();
        $this->getCommonUtil()->CommonObjectProperties($commandObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($commandObj, $properties);

        $commandObj->save();
        return $commandObj;
    }

    /**
     * @param array $properties
     * @return Route
     */
    public function CreateGate(array $properties)
    {
        $gateObj = new Gate();
        $this->getCommonUtil()->CommonObjectProperties($gateObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($gateObj, $properties);

        $gateObj->save();
        return $gateObj;
    }

    /**
     * @param array $properties
     * @return UseCase
     * @throws Exception_WorkFlow
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function CreateUseCase(array $properties)
    {
        if (!isset($properties['Description'])) {
            $properties['Description'] = $properties['Name'];
        }
        if (!isset($properties['UseCaseStatus'])) {
            $properties['UseCaseStatus'] = UseCaseStatusEnum::OPEN;
        }
        $use_case_contexts = [];
        if (isset($properties['UseCaseContexts']))
        {
            $use_case_contexts = $properties['UseCaseContexts'];
            unset($properties['UseCaseContexts']);
        }
        $useCaseObj = new UseCase();
        $this->getCommonUtil()->CommonObjectProperties($useCaseObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($useCaseObj, $properties);
        $useCaseObj->save();

        foreach($use_case_contexts as $name => $value)
        {
            $this->CreateUseCaseContext(
                [
                    'UseCaseId' => $useCaseObj->getUseCaseId(),
                    'Name' => $name,
                    'Value' => $value
                ]
            );
        }

        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $WorkFlowEngine = new WorkFlowEngine($useCaseObj->getUseCaseId());
            $WorkFlowEngine->initiateUseCase();
            $con->commit();
        } catch (Exception_WorkFlow $exceptionObj) {
            $con->rollBack();
            throw $exceptionObj;
        } catch (\Exception $exceptionObj) {
            $con->rollBack();
            throw new Exception_WorkFlow($exceptionObj->getMessage() . $exceptionObj->getTraceAsString());
        }

        return $useCaseObj;
    }

    /**
     * @return int
     */
    public function FetchUseCaseCount()
    {
        return UseCaseQuery::create()->count();
    }

    /**
     * @return int
     */
    public function FetchTokenCount()
    {
        return TokenQuery::create()->count();
    }

    /**
     * @return int
     */
    public function FetchWorkItemCount()
    {
        return WorkItemQuery::create()->count();
    }
    /**
     * @return int
     */
    public function FetchUseCaseContextCount()
    {
        return UseCaseContextQuery::create()->count();
    }

    /**
     * @return int
     */
    public function FetchRouteCount()
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Route'],
            function(){
                return RouteQuery::create()->count();
            }
        );
    }

    /**
     * @param       $use_case_id int
     * @param array $properties
     * @return UseCase
     */
    public function UpdateUseCaseWithUseCaseId($use_case_id, array $properties)
    {
        if (isset($properties['StartDate'])) {
            $expiration_AsATimestamp = strtotime($properties['StartDate']);
            $properties['StartDate'] = $expiration_AsATimestamp;
        }
        if (isset($properties['end_date'])) {
            $expiration_AsATimestamp = strtotime($properties['EndDate']);
            $properties['EndDate'] = $expiration_AsATimestamp;
        }
        return UseCaseQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->update($properties);
    }


    /**
     * @param       $use_case_id int
     * @param array $properties
     * @return UseCase
     */
    public function UpdateUseCaseContextWithUseCaseIdAndName($use_case_id, $name, array $properties)
    {
        return UseCaseQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByName($name)
            ->update($properties);
    }

    /**
     * @param $use_case_id
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function DeleteUseCaseWithUseCaseId($use_case_id)
    {
        $useCaseObj = UseCaseQuery::create()->findOneByUseCaseId($use_case_id);
        $useCaseObj->delete();
        return true;
    }

    /**
     * @param $use_case_id
     * @param $name
     * @return int
     */
    public function DeleteUseCaseContextWithUseCaseIdAndName($use_case_id, $name)
    {
        return UseCaseQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByName($name)
            ->delete();
    }

    /**
     * @param $work_flow_id
     * @return bool
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function DeleteWorkFlowWithWorkFlowId($work_flow_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperInsertUpdateDelete(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow'],
            function($work_flow_id){
                $workFlowObjArr = WorkFlowQuery::create()->findByWorkFlowId($work_flow_id)->getFirst();
                $workFlowObjArr->delete();
                return true;
            }
        );
    }

    /**
     * @param       $token_id
     * @param array $properties
     * @return int
     * @throws \PHPWorkFlow\Exception_WorkFlow
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function UpdateToken($token_id, array $properties)
    {
        if (isset($properties['TokenStatus'])) {
            $tokenObj = $this->FetchTokenWithTokenId($token_id);
            if (!$tokenObj->getTokenStatus() == TokenStatusEnum::FREE) {
                throw new Exception_WorkFlow('cannot change status of a non-free token');
            }
        }
        return TokenQuery::create()
            ->filterByTokenId($token_id)
            ->update($properties);
    }

    /**
     * @param $work_item_id
     * @param $properties
     * @return int
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function UpdateWorkItem($work_item_id, $properties)
    {
        return WorkItemQuery::create()
            ->filterByWorkItemId($work_item_id)
            ->update($properties);
    }

    /**
     * @param $work_flow_id
     * @param $yasper_name
     * @return Transition
     */
    public function FetchTransitionWithWorkFlowIdAndYasperName($work_flow_id, $yasper_name)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow', 'Transition'],
            function($work_flow_id, $yasper_name){
                return TransitionQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->filterByYasperName($yasper_name)
                    ->findOne();
            }
        );
    }

    /**
     * @param $token_id
     * @return Token
     */
    public function FetchTokenWithTokenId($token_id)
    {
        return TokenQuery::create()
            ->filterByTokenId($token_id)
            ->findOne();
    }

    /**
     * @param $token_id
     * @return Token
     */
//    public function FetchUseCaseWithUseCaseContextKeyValuePairs($key_value_pairs_arr)
//    {
//        $con = Propel::getWriteConnection(DB\Map\UseCaseContextTableMap::DATABASE_NAME);
//        $sql = "SELECT * FROM use_case_context WHERE
//                  id NOT IN "
//            ."(SELECT book_review.book_id FROM book_review"
//            ." INNER JOIN author ON (book_review.author_id=author.ID)"
//            ." WHERE author.last_name = :name)";
//        $stmt = $con->prepare($sql);
//        $stmt->execute(array(':name' => 'Austen'));
//
//        $UseCaseQueryObj = UseCaseQuery::create();
//        $UseCaseQueryObj->join('UseCase.UseCaseContext');
//        $UseCaseQueryObj->where('UseCaseContext.name IN ?', array_keys($key_value_pairs_arr));
//        $UseCaseQueryObj->where('UseCaseContext.value IN ?', array_values($key_value_pairs_arr));
//        $UseCaseQueryObj->groupBy('UseCaseContext.use_case_id');
//
//        foreach($key_value_pairs_arr as $key => $value)
//        {
//            if(method_exists($UseCaseContextQueryObj))
//            ->
//        }filterByTokenId($token_id)
//            ->findOne();
//    }

    /**
     * @param $work_flow_id
     * @param $yasper_name
     * @return Place
     */
    public function FetchPlaceWithWorkFlowIdAndYasperName($work_flow_id, $yasper_name)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow'],
            function($work_flow_id, $yasper_name){
                return PlaceQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->filterByYasperName($yasper_name)
                    ->findOne();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @param $yasper_name
     * @return Arc
     */
    public function FetchArcWithWorkFlowIdAndName($work_flow_id, $yasper_name)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow', 'Arc'],
            function($work_flow_id, $yasper_name){
                return ArcQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->filterByName($yasper_name)
                    ->findOne();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @param $yasper_name
     * @return Arc
     */
    public function FetchArcWithWorkFlowIdAndYasperName($work_flow_id, $yasper_name)
    {
        return ArcQuery::create()
            ->filterByWorkFlowId($work_flow_id)
            ->filterByYasperName($yasper_name)
            ->findOne();
    }

    /**
     * @param $work_flow_id
     * @param $name
     * @return Place
     */
    public function FetchPlaceWithWorkFlowIdAndName($work_flow_id, $name)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow', 'Place'],
            function($work_flow_id, $name){
                return PlaceQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->filterByName($name)
                    ->findOne();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @param $name
     * @return Transition
     */
    public function FetchTransitionWithWorkFlowIdAndName($work_flow_id, $name)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow', 'Transition'],
            function($work_flow_id, $name){
                return TransitionQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->filterByName($name)
                    ->findOne();
            }
        );
    }

    /**
     * @param $transition_id
     * @return Transition
     */
    public function FetchTransitionWithTransitionId($transition_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow', 'Transition'],
            function($transition_id){
                return TransitionQuery::create()
                    ->filterByTransitionId($transition_id)
                    ->findOne();
            }
        );
    }

    /**
     * @param $transition_id
     * @return DB\Notification[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchNotificationsArrWithTransitionId($transition_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Transition', 'Notification'],
            function($transition_id){
                return NotificationQuery::create()
                    ->filterByTransitionId($transition_id)
                    ->find()->getData();
            }
        );
    }

    /**
     * @return Transition[]
     */
    public function FetchTransitionArr()
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Transition', 'Notification'],
            function(){
                return TransitionQuery::create()
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $name
     * @return WorkFlow
     */
    public function FetchWorkFlowWithName($name)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow'],
            function($name){
                return DB\WorkFlowQuery::create()
                    ->filterByName($name)
                    ->findOne();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @return \Propel\Runtime\Collection\ObjectCollection|Transition[]
     */
    public function FetchTransitionArrWithWorkFlowId($work_flow_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Transition', 'WorkFlow'],
            function($work_flow_id){
                return TransitionQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->orderByYasperName()
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @param $transition_type
     * @return DB\Transition[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchTransitionArrWithWorkFlowIdAndTransitionType($work_flow_id, $transition_type)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Transition', 'WorkFlow'],
            function($work_flow_id, $transition_type){
                return TransitionQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->filterByTransitionType($transition_type)
                    ->orderByYasperName()
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @return DB\Place[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchPlaceArrWithWorkFlowId($work_flow_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Place', 'WorkFlow'],
            function($work_flow_id){
                return PlaceQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->orderByYasperName()
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $place_id
     * @return DB\Place[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchPlaceWithPlaceId($place_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Place'],
            function($place_id){
                return PlaceQuery::create()
                    ->filterByPlaceId($place_id)
                    ->findOne();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @return DB\Route[]|\Propel\Runtime\Collection\ObjectCollection
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function FetchRouteArrWithWorkFlowId($work_flow_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow', 'Route', 'Transition'],
            function($work_flow_id){
                return RouteQuery::create()
                    ->join('Route.Transition')
                    ->where('Transition.work_flow_id = ?', $work_flow_id)
                    ->orderByRoute()
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @return DB\Notification[]|\Propel\Runtime\Collection\ObjectCollection
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function FetchNotificationArrWithWorkFlowId($work_flow_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Transition', 'Notification', 'WorkFlow'],
            function($work_flow_id){
                return NotificationQuery::create()
                    ->join('Notification.Transition')
                    ->where('Transition.work_flow_id = ?', $work_flow_id)
                    ->orderByNotificationType()
                    ->orderByNotificationString()
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @return DB\Gate[]|\Propel\Runtime\Collection\ObjectCollection
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function FetchGateArrWithWorkFlowId($work_flow_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Transition', 'Gate', 'WorkFlow'],
            function($work_flow_id){
                return GateQuery::create()
                    ->join('Gate.Transition')
                    ->where('Transition.work_flow_id = ?', $work_flow_id)
                    ->orderByTargetYasperName()
                    ->orderByValue()
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @param $transition_id
     * @return DB\Route[]|\Propel\Runtime\Collection\ObjectCollection
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function FetchRouteArrWithWorkFlowIdAndTransitionId($work_flow_id, $transition_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Transition', 'Route', 'WorkFlow'],
            function($work_flow_id, $transition_id){
                return RouteQuery::create()
                    ->join('Route.Transition')
                    ->where('Transition.work_flow_id = ?', $work_flow_id)
                    ->where('Transition.transition_id = ?', $transition_id)
                    ->orderByRoute()
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @param $route
     * @return Route
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function FetchRouteWithWorkFlowIdAndRoute($work_flow_id, $route)
    {
        return RouteQuery::create()
            ->join('Route.Transition')
            ->where('Transition.work_flow_id = ?', $work_flow_id)
            ->where('Route.route = ?', $route)
            ->orderByRoute()
            ->findOne();
    }

    /**
     * @param $work_flow_id
     * @return Arc[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchArcArrWithWorkFlowId($work_flow_id)
    {
        return ArcQuery::create()
            ->filterByWorkFlowId($work_flow_id)
            ->find()->getData();
    }

    /**
     * @param $work_flow_id
     * @return Place
     */
    public function FetchStartPlaceWithWorkFlowId($work_flow_id)
    {
        return PlaceQuery::create()
            ->filterByWorkFlowId($work_flow_id)
            ->filterByPlaceType(Enum\PlaceTypeEnum::START_PLACE)
            ->findOne();
    }

    /**
     * @param $work_flow_id
     * @return Place
     */
    public function FetchEndPlaceWithWorkFlowId($work_flow_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow', 'Place'],
            function($work_flow_id){
                return PlaceQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->filterByPlaceType(Enum\PlaceTypeEnum::END_PLACE)
                    ->findOne();
            }
        );
    }

    /**
     * @param $use_case_id
     * @return UseCase|bool
     */
    public function FetchUseCaseWithUseCaseId($use_case_id)
    {
        return UseCaseQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->findOne();
    }

    /**
     * @param $work_flow_id
     * @return WorkFlow
     */
    public function FetchWorkFlowWithWorkFlowId($work_flow_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow'],
            function($work_flow_id){
                return WorkFlowQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->findOne();
            }
        );
    }

    /**
     * @param $properties
     * @return Token
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function CreateToken($properties)
    {
        $tokenFlowObj = new Token();
        $this->getCommonUtil()->CommonObjectProperties($tokenFlowObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($tokenFlowObj, $properties);
        $tokenFlowObj->save();
        return $tokenFlowObj;
    }

    /**
     * @param $place_id
     * @return DB\Arc[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchInwardArcArrWithPlaceId($place_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Arc', 'Place'],
            function($place_id){
                return ArcQuery::create()
                    ->filterByPlaceId($place_id)
                    ->filterByDirection('IN')
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $transition_id
     * @return DB\Arc[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchInwardArcArrWithTransitionId($transition_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Arc', 'Transition'],
            function($transition_id){
                return ArcQuery::create()
                    ->filterByTransitionId($transition_id)
                    ->filterByDirection('IN')
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $use_case_id
     * @param $place_id
     * @param $token_status
     * @return DB\Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchTokenWithUseCaseIdAndPlaceIdAndTokenStatus($use_case_id, $place_id, $token_status)
    {
        return TokenQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByPlaceId($place_id)
            ->filterByTokenStatus($token_status)
            ->findOne();
    }

    /**
     * @param $use_case_id
     * @param $place_id
     * @param $token_status
     * @return DB\Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchTokenWithUseCaseIdAndPlaceIdAndTokenStatusCount($use_case_id, $place_id, $token_status)
    {
        return TokenQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByPlaceId($place_id)
            ->filterByTokenStatus($token_status)
            ->count();
    }

    /**
     * @param $properties
     * @return WorkItem
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function CreateWorkItem($properties)
    {
        if (!isset($properties['CancelledDate'])) {
            $properties['CancelledDate'] = null;
        }
        if (!isset($properties['FinishedDate'])) {
            $properties['FinishedDate'] = null;
        }
        $workItemObj = new WorkItem();
        $this->getCommonUtil()->CommonObjectProperties($workItemObj);
        $this->getCommonUtil()->PopulateObjectWithProperties($workItemObj, $properties);
        $workItemObj->save();
        return $workItemObj;
    }

    /**
     * @param $use_case_id
     * @return DB\WorkItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchEnabledWorkItemArrWithUseCaseId($use_case_id)
    {
        return WorkItemQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByWorkItemStatus(WorkItemStatusEnum::ENABLED)
            ->find()->getData();
    }
    /**
     * @param $use_case_id
     * @return DB\WorkItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchEnabledWorkItemArrWithUseCaseIdAndRoute($use_case_id, $route)
    {
        return WorkItemQuery::create()
            ->join('WorkItem.Transition')
            ->where('Transition.transition_type = ?', TransitionTypeEnum::USER)
            ->join('Transition.Route')
            ->where('WorkItem.use_case_id = ?', $use_case_id)
            ->where('WorkItem.work_item_status = ?', WorkItemStatusEnum::ENABLED)
            ->where('Route.route = ?', $route)
            ->find()->getData();
    }

    /**
     * @param $use_case_id
     * @return DB\WorkItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchEnabledWorkItemWithUseCaseIdCount($use_case_id)
    {
        return WorkItemQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByWorkItemStatus(WorkItemStatusEnum::ENABLED)
            ->count();
    }

    /**
     * @param $route
     * @return DB\Arc[]|DB\WorkFlow[]|DB\WorkItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchEnabledWorkItemArrWithRoute($route)
    {
        return WorkItemQuery::create()
            ->join('WorkItem.Transition')
            ->join('Transition.Route')
            ->where('Route.route = ?', $route)
            ->where('WorkItem.work_item_status = ?', WorkItemStatusEnum::ENABLED)
            ->find()->getData();
    }

    /**
     * @param string $work_item_status
     * @return DB\WorkItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchWorkItemArrWithWorkItemStatus($work_item_status = WorkItemStatusEnum::ENABLED)
    {
        return WorkItemQuery::create()
            ->filterByWorkItemStatus($work_item_status)
            ->find()->getData();
    }

    /**
     * @return DB\Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchFreeInboundTokensArr()
    {
        return TokenQuery::create()
            ->filterByTokenStatus(TokenStatusEnum::FREE)
            ->find()->getData();
    }

    /**
     * @param $use_case_id
     * @param $work_item_id
     * @return array|mixed|DB\Token[]|\Propel\Runtime\ActiveRecord\ActiveRecordInterface[]|\Propel\Runtime\Collection\ObjectCollection
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function FetchInboundTokensWithWorkItemIdArr($use_case_id, $work_item_id)
    {
        return TokenQuery::create()
            ->join('Token.Place')
            ->join('Place.Arc')
            ->join('Arc.Transition')
            ->join('Transition.WorkItem')
            ->where('Arc.direction = ?', 'IN')
            ->where('Token.use_case_id = ?', $use_case_id)
            ->where('WorkItem.work_item_id = ?', $work_item_id)
            ->find()->getData();
    }

    /**
     * @param $use_case_id
     * @param $work_item_id
     * @return array|mixed|DB\Token[]|\Propel\Runtime\ActiveRecord\ActiveRecordInterface[]|\Propel\Runtime\Collection\ObjectCollection
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function FetchFreeInboundTokensWithWorkItemIdArr($use_case_id, $work_item_id)
    {
        return TokenQuery::create()
            ->join('Token.Place')
            ->join('Place.Arc')
            ->join('Arc.Transition')
            ->join('Transition.WorkItem')
            ->where('Arc.direction = ?', 'IN')
            ->where('Token.use_case_id = ?', $use_case_id)
            ->where('WorkItem.work_item_id = ?', $work_item_id)
            ->where('Token.token_status = ?', TokenStatusEnum::FREE)
            ->find()->getData();
    }

    /**
     * @param $work_item_id
     * @return array|mixed|DB\Place[]|\Propel\Runtime\ActiveRecord\ActiveRecordInterface[]|\Propel\Runtime\Collection\ObjectCollection
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function FetchInboundPlacesWithWorkItemIdArr($work_item_id)
    {
        return PlaceQuery::create()
            ->join('Place.Arc')
            ->join('Arc.Transition')
            ->join('Transition.WorkItem')
            ->where('Arc.direction = ?', 'IN')
            ->where('WorkItem.work_item_id = ?', $work_item_id)
            ->find()->getData();
    }

    /**
     * @param $work_item_id
     * @return WorkItem
     */
    public function FetchWorkItemWithWorkItemId($work_item_id)
    {
        return WorkItemQuery::create()
            ->filterByWorkItemId($work_item_id)
            ->findOne();
    }

    /**
     * @param $work_item_id
     * @return array|mixed|DB\Place[]|\Propel\Runtime\ActiveRecord\ActiveRecordInterface[]|\Propel\Runtime\Collection\ObjectCollection
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function FetchOutboundPlacesWithWorkItemIdArr($work_item_id)
    {
        return PlaceQuery::create()
            ->join('Place.Arc')
            ->join('Arc.Transition')
            ->join('Transition.WorkItem')
            ->where('Arc.direction = ?', 'OUT')
            ->where('WorkItem.work_item_id = ?', $work_item_id)
            ->find()->getData();
    }

    /**
     * @param $use_case_id
     * @return DB\Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchFreeTokenWithUseCaseIdArr($use_case_id)
    {
        return TokenQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByTokenStatus(TokenStatusEnum::FREE)
            ->find()->getData();
    }

    /**
     * @param $use_case_id
     * @return DB\Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchFreeTokenWithUseCaseIdCount($use_case_id)
    {
        return TokenQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByTokenStatus(TokenStatusEnum::FREE)
            ->count();
    }

    /**
     * @param $use_case_id
     * @param $transition_trigger_method
     * @return Arc|WorkItem
     */
    public function FetchEnabledWorkItemArrWithUseCaseIdAndTransitionTriggerMethod($use_case_id, $transition_trigger_method)
    {
        return WorkItemQuery::create()
            ->useTransitionQuery()
            ->filterByTransitionTriggerMethod($transition_trigger_method)
            ->endUse()
            ->filterByWorkItemStatus(WorkItemStatusEnum::ENABLED)
            ->filterByUseCaseId($use_case_id)
            ->findOne();
    }

    /**
     * @param $use_case_id
     * @param $transition_trigger_method
     * @return int
     */
    public function FetchEnabledWorkItemWithUseCaseIdAndTransitionTriggerMethodCount($use_case_id, $transition_trigger_method)
    {
        return WorkItemQuery::create()
            ->useTransitionQuery()
            ->filterByTransitionTriggerMethod($transition_trigger_method)
            ->endUse()
            ->filterByWorkItemStatus(WorkItemStatusEnum::ENABLED)
            ->filterByUseCaseId($use_case_id)
            ->count();
    }

    /**
     * @param $use_case_id
     * @param $place_id
     * @return DB\Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchEnabledTokenWithUseCaseIdAndPlaceIdArr($use_case_id, $place_id)
    {
        return TokenQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByPlaceId($place_id)
            ->filterByTokenStatus(TokenStatusEnum::FREE)
            ->find()->getData();
    }

    /**
     * @param $use_case_id
     * @return DB\WorkItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchWorkItemArrWithUseCaseIdArr($use_case_id)
    {
        return WorkItemQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->find()->getData();
    }

    /**
     * @param $use_case_id
     * @param $transition_id
     * @return WorkItem
     */
    public function FetchEnabledWorkItemWithUseCaseIdAndTransitionId($use_case_id, $transition_id)
    {
        return WorkItemQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByTransitionId($transition_id)
            ->filterByWorkItemStatus(WorkItemStatusEnum::ENABLED)
            ->findOne();
    }

    /**
     * @param $use_case_id
     * @param $transition_id
     * @return WorkItem
     */
    public function FetchCancelledWorkItemWithUseCaseIdAndTransitionId($use_case_id, $transition_id)
    {
        return WorkItemQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByTransitionId($transition_id)
            ->filterByWorkItemStatus(WorkItemStatusEnum::CANCELLED)
            ->findOne();
    }

    /**
     * @param int $use_case_id
     * @param int $transition_id
     * @return WorkItem
     */
    public function FetchFinishedWorkItemWithUseCaseIdAndTransitionId($use_case_id, $transition_id)
    {
        return WorkItemQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->filterByTransitionId($transition_id)
            ->filterByWorkItemStatus(WorkItemStatusEnum::FINISHED)
            ->findOne();
    }

    /**
     * @return WorkItem
     */
    public function FetchTokenArr()
    {
        return TokenQuery::create()
            ->find()->getData();
    }

    /**
     * @param int $use_case_id
     * @return DB\Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchTokenArrWithUseCaseId($use_case_id)
    {
        return TokenQuery::create()
            ->filterByUseCaseId($use_case_id)
            ->find()->getData();
    }

    /**
     * @param string $token_status
     * @return DB\Token[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchTokenArrWithTokenStatus($token_status)
    {
        return TokenQuery::create()
            ->filterByTokenStatus($token_status)
            ->find()->getData();
    }

    /**
     * @return DB\WorkFlow[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function FetchAllWorkFlows()
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['WorkFlow'],
            function(){
                return WorkFlowQuery::create()
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $work_flow_id
     * @param $transition_trigger_method
     * @return Transition
     */
    public function FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod($work_flow_id, $transition_trigger_method)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['Transition', 'WorkFlow'],
            function($work_flow_id, $transition_trigger_method){
                return TransitionQuery::create()
                    ->filterByWorkFlowId($work_flow_id)
                    ->filterByTransitionTriggerMethod($transition_trigger_method)
                    ->findOne();
            }
        );
    }

    /**
     * @param $use_case_id
     * @return UseCase[]
     */
    public function FetchChildrenWithParentUseCaseId($use_case_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['UseCase'],
            function($use_case_id){
                return UseCaseQuery::create()
                    ->filterByParentUseCaseId($use_case_id)
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $use_case_id
     * @return UseCase[]
     */
    public function FetchOpenChildrenWithParentUseCaseId($use_case_id)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['UseCase'],
            function($use_case_id){
                return UseCaseQuery::create()
                    ->filterByParentUseCaseId($use_case_id)
                    ->filterByUseCaseStatus(UseCaseStatusEnum::OPEN)
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $use_case_id
     * @param $use_case_group
     * @return UseCase[]
     */
    public function FetchOpenChildrenWithParentUseCaseIdAndUseCaseGroup($use_case_id, $use_case_group)
    {
        return NeverWrongCacheUtil::GenericCacheWrapperFetch(
            __CLASS__,
            __FUNCTION__,
            func_get_args(),
            ['UseCase'],
            function($use_case_id, $use_case_group){
                return UseCaseQuery::create()
                    ->filterByParentUseCaseId($use_case_id)
                    ->filterByUseCaseGroup($use_case_group)
                    ->filterByUseCaseStatus(UseCaseStatusEnum::OPEN)
                    ->find()->getData();
            }
        );
    }

    /**
     * @param $function
     * @return int
     */
    static function DAOCacheSwitch($function)
    {
        switch ($function) {
            case 'FetchTransitionWithWorkFlowIdAndTransitionTriggerMethod':
                return 15000;
            case 'FetchWorkFlowWithWorkFlowId':
                return 10000;
            case 'FetchAllWorkFlows':
                return 10000;
            default:
                return 10000;
        }
    }
}
