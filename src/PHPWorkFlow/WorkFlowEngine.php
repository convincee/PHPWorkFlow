<?php
namespace PHPWorkFlow;

use PHPWorkFlow\DB\UseCase;
use PHPWorkFlow\DB\Place;
use PHPWorkFlow\DB\WorkItem;
use PHPWorkFlow\DB\Token;
use PHPWorkFlow\DB\Transition;
use PHPWorkFlow\Enum\TokenStatusEnum;
use PHPWorkFlow\Enum\WorkItemStatusEnum;
use PHPWorkFlow\Enum\PlaceTypeEnum;
use PHPWorkFlow\Enum\ArcTypeEnum;

/**
 * Class WorkFlowEngine
 * @package PHPWorkFlow
 */
class WorkFlowEngine
{
    use WorkFlowDAOTrait;
    /**
     * @var null|UseCase
     */
    protected $useCaseObj = null;
    /**
     * @var WorkItem[]
     */
    protected $allWorkItemsCreatedObjArr = [];

    /**
     * @param $use_case_id
     * @throws Exception_WorkFlow
     */
    public function __construct($use_case_id)
    {
        $this->useCaseObj = $this->getWorkFlowDAO()->FetchUseCaseWithUseCaseId($use_case_id);
        if(! $this->useCaseObj )
        {
            throw new Exception_WorkFlow('No useCaseObj found in WorkFlowEngine');
        }
    }

    /**
     * @return bool
     * @throws Exception_WorkFlow
     */
    public function initiateUseCase()
    {
        $this->DropToken(
            $this->useCaseObj->getWorkFlow()->getStartPlace(),
            TokenStatusEnum::FREE,
            null  /* since we're init-ing - the work_item_id = null */
        );
        $this->PushWorkItems();
    }

    /**
     * @param Token $tokenObj
     * @return void
     */
    public function ConsumeToken(Token $tokenObj, $work_item_id)
    {
        /*
         * get all workItems that this token points into
         */
        $workItemObjArr = $tokenObj->GetInboundWorkItems();
        foreach ($workItemObjArr as $workItemObj) {
            if ($workItemObj->getWorkItemStatus() == WorkItemStatusEnum::ENABLED) {
                $this->getWorkFlowDAO()->UpdateWorkItem(
                    $workItemObj->getWorkItemId(),
                    [
                        'WorkItemStatus' => WorkItemStatusEnum::CANCELLED,
                        'CancelledDate' => time()
                    ]
                );
            }
        }
        $this->getWorkFlowDAO()->UpdateToken(
            $tokenObj->getTokenId(),
            [
                'TokenStatus' => Enum\TokenStatusEnum::CONSUMED,
                'ConsumedDate' => time(),
                'ConsumingWorkItemId' => $work_item_id
            ]
        );
    }

    /**
     * @param Place $placeToDropTokenObj
     * @param string $tokenType
     * @param $work_item_id
     * @return array|bool
     * @throws Exception_WorkFlow
     */
    public function DropToken(Place $placeToDropTokenObj, $tokenType = TokenStatusEnum::FREE, $work_item_id)
    {
        $tokenObj = $this->getWorkFlowDAO()->CreateToken(
            [
                'UseCaseId' => $this->useCaseObj->getUseCaseId(),
                'PlaceId' => $placeToDropTokenObj->getPlaceId(),
                'TokenStatus' => $tokenType,
                'EnabledDate' => time(),
                'CreatingWorkItemId' => $work_item_id
            ]
        );
        /*************************
         * Whenever a token is created in a place the following checks are made:
         *  * If it is the end place then the USE_CASE is closed.
         *  * Find all inward arcs which go from this place into a transitions, and for each transition perform the following:
         *      o Get a list of all places which input to the transition.
         *      o Check that each of these places has a token (an AND-join must have one token for each input place).
         *        If the correct number of tokens is found then:
         *          + enable the transition (create a new WorkItem record).
         *          + If the transition trigger is 'AUTO' then process that TASK immediately, otherwise wait for some other trigger.
         *
         */

        /**********************
         * If it is the end place then the CASE is closed.
         * ********************
         *
         * If we are dropping a Token on a 'End' place, by
         * Definition, this UseCase if finished so mark it so and do a little cleanup
         */
        if ($tokenObj->getPlace()->getPlaceType() == PlaceTypeEnum::END_PLACE) {
            /*
             * let's mark the UseCase = 'Closed'
             */
            if(! $tokenObj->getUseCase()->numOpenChildren())
            {
                $this->closeCase($work_item_id);
            }
            return [];
        }

        /*
         * Find all inward arcs which go from this tokens place into a transition and create a
         * list of those transitions
         */
        $inwardArcOfPlaceObjArr = $tokenObj->getPlace()->getInwardArcArr();
        $transitionThatPointedInToPlaceObjArr = [];
        foreach ($inwardArcOfPlaceObjArr as $inwardArcOfPlaceObj) {
            /*
             * for each inward arc
             */
            $transitionThatPointedInToPlaceObjArr[] = $inwardArcOfPlaceObj->getTransition();
        }

        /*
         * now that we have our list of transitions that can be potentially be
         * enabled as a result of the dropping this token, for each we need to determine
         * if sufficient places that point
         * into the Transition in question hold tokens
         */

        /**
         * @var Transition $transitionThatPointedInToPlaceObj
         */
        foreach ($transitionThatPointedInToPlaceObjArr as $transitionThatPointedInToPlaceObj) {
            /*
             * Get a list of all places which input to the transition.
             * Remember that by definition,
             *  - All arcs into the same transition have same type
             *  - All arcs out of the same transition have same type
             *  - All arcs into the same place have same type
             *  - All arcs out of the same place have same type
             *
             * Also remember that by def, only one SEQ arc can point into or out of a place or transition
             */

            /*
             * also remember that when discussing the direction of an arc, the direction is always
             * with respect to the transition it points into or out of.
             */

            $inwardArcObjArr = $transitionThatPointedInToPlaceObj->getInwardArcArr();
            if (count($inwardArcObjArr) == 0) {
                throw new Exception_WorkFlow("WorkItem w/ messed up arcs Threw Exception " . __FILE__ . __LINE__);
            }

            /*
             * determine if these arcs (the arcs that emanates OUTWARD from the place we are trying to drop this token)
             * are OR-JOIN or SEQ.
             *
             * If OR-JOIN, then we are $readyToEnableTransition if
             * one ('or more' I suppose more but I would be suspicious)
             * of the $inwardArcObjArr has a token.
             *
             * If SEQ, this we are $readyToEnableTransition if ALL
             * places in $inwardArcObjArr have tokens.
             */
            $arc_type = $this->extractAndCheckArcType($inwardArcObjArr);

            /*
             * based on the type of arcs pointing into the transition in question......
             */
            if ($arc_type == ArcTypeEnum::SEQ) {
                $readyToEnableTransition = false;
                /*
                 * SEQ is the simple case, we are $readyToEnableTransition if token present
                 *
                 * Remember that by def, we're only dealing w/ one arc
                 */
                $inwardArcObj = $inwardArcObjArr[0];
                if ($this->getWorkFlowDAO()->FetchTokenWithUseCaseIdAndPlaceIdAndTokenStatusCount(
                    $this->useCaseObj->getUseCaseId(),
                    $inwardArcObj->getPlaceId(),
                    TokenStatusEnum::FREE
                )
                ) {
                    $readyToEnableTransition = true;
                }
            } elseif ($arc_type == ArcTypeEnum::AND_JOIN) {
                $readyToEnableTransition = true;
                /*
                 * in the AndJoin case, we are $readyToEnableTransition if ALL inward arcs have a token
                 */
                foreach ($inwardArcObjArr as $inwardArcObj) {
                    if (!$this->getWorkFlowDAO()->FetchTokenWithUseCaseIdAndPlaceIdAndTokenStatusCount(
                        $this->useCaseObj->getUseCaseId(),
                        $inwardArcObj->getPlaceId(),
                        TokenStatusEnum::FREE
                    )
                    ) {
                        $readyToEnableTransition = false;
                        break;
                    }
                }
            } elseif ($arc_type == ArcTypeEnum::OR_SPLIT) {
                $readyToEnableTransition = false;
                /*
                 * in the OrSplit case, we are $readyToEnableTransition if ANY inward arcs has a token
                 */
                foreach ($inwardArcObjArr as $inwardArcObj) {
                    if ($this->getWorkFlowDAO()->FetchTokenWithUseCaseIdAndPlaceIdAndTokenStatusCount(
                        $this->useCaseObj->getUseCaseId(),
                        $inwardArcObj->getPlaceId(),
                        TokenStatusEnum::FREE
                    )
                    ) {
                        $readyToEnableTransition = true;
                        break;
                    }
                }
            }
            else {
                throw new Exception_WorkFlow("WorkItem w/ messed up arcs Threw Exception " . __FILE__ . __LINE__);
            }

            if ($readyToEnableTransition) {
                /*
                 * this transition is ready so fire away
                 */
                $this->allWorkItemsCreatedObjArr[] = $this->getWorkFlowDAO()->CreateWorkItem(
                    [
                        'UseCaseId' => $this->useCaseObj->getUseCaseId(),
                        'TransitionId' => $transitionThatPointedInToPlaceObj->getTransitionId(),
                        'WorkItemStatus' => WorkItemStatusEnum::ENABLED,
                        'EnabledDate' => time()
                    ]
                );
            }
        }
        return $tokenObj;
    }

    /**
     * @param $work_item_id
     */
    public function closeCase($work_item_id)
    {
        $this->getWorkFlowDAO()->UpdateUseCaseWithUseCaseId(
            $this->useCaseObj->getUseCaseId(),
            [
                'UseCaseStatus' => Enum\UseCaseStatusEnum::CLOSED,
                'EndDate' => time()
            ]
        );
        /*
         * let's mark all the non-finished and non-cancelled WorkItems to 'Cancelled'
         * @todo - Figure out that to do with 'In Process' WorkItems
         */
        $workItemObjArr = $this->getWorkFlowDAO()->FetchWorkItemArrWithUseCaseIdArr(
            $this->useCaseObj->getUseCaseId()
        );
        foreach ($workItemObjArr as $workItemObj) {
            if ($workItemObj->getWorkItemStatus() == WorkItemStatusEnum::FINISHED) {
                continue;
            }
            $this->getWorkFlowDAO()->UpdateWorkItem(
                $workItemObj->getWorkItemId(),
                [
                    'WorkItemStatus' => WorkItemStatusEnum::CANCELLED
                ]
            );
        }
        /*
         * let's mark all the non-consumed and non-End Tokens to 'Cancelled' (never should happen
         * under normal driving conditions)
         * and let's set the end token to consumed
         * @todo - Figure out that to do with 'Locked' Tokens
         */
        $tokenObjArr = $this->getWorkFlowDAO()->FetchTokenArrWithUseCaseId(
            $this->useCaseObj->getUseCaseId()
        );
        foreach ($tokenObjArr as $tokenObj) {
            if ($tokenObj->getPlace()->getPlaceType() == Enum\PlaceTypeEnum::END_PLACE) {
                $this->getWorkFlowDAO()->UpdateToken(
                    $tokenObj->getTokenId(),
                    [
                        'TokenStatus' => TokenStatusEnum::CONSUMED,
                        'CancelledDate' => time(),
                        'ConsumingWorkItemId' => $work_item_id
                    ]
                );
                continue;
            }
            if ($tokenObj->getTokenStatus() == TokenStatusEnum::CONSUMED) {
                continue;
            }
            if ($tokenObj->getTokenStatus() == TokenStatusEnum::CANCELLED) {
                continue;
            }
            $this->getWorkFlowDAO()->UpdateToken(
                $tokenObj->getTokenId(),
                [
                    'TokenStatus' => TokenStatusEnum::CANCELLED,
                    'CancelledDate' => time()
                ]
            );
        }
        return;
    }

    /**
     * @return WorkItem[]
     */
    public function get_allWorkItemsCreatedObjArr()
    {
        $this->clean_allWorkItemsCreatedObjArr();
        return $this->allWorkItemsCreatedObjArr;
    }

    /**
     * @return void
     */
    private function clean_allWorkItemsCreatedObjArr()
    {
        $cleaned_allWorkItemsCreatedObjArr = [];
        foreach ($this->allWorkItemsCreatedObjArr as $workItemObj) {
            if ($workItemObj->getWorkItemStatus() == WorkItemStatusEnum::ENABLED) {
                $cleaned_allWorkItemsCreatedObjArr[] = $workItemObj;
            }
        }
        $this->allWorkItemsCreatedObjArr = $cleaned_allWorkItemsCreatedObjArr;
    }

    /**
     * @return bool
     * @throws Exception_WorkFlow
     */
    public function PushWorkItems()
    {
        $workFlowTraffickerObj = new WorkFlowTrafficker(
            null,
            $this->useCaseObj->getUseCaseId()
        );
        $workFlowTraffickerObj->checkWorkItemsForCompleteness();
    }

    /**
     * Get the type of arcs in $inwardArcObjArr - remember they must
     * be homogeneous WRT type
     *
     * @param $inwardArcObjArr DB\Arc[]
     * @return string
     * @throws Exception_WorkFlow
     */
    public function extractAndCheckArcType($inwardArcObjArr)
    {
        $SEQ = false;
        $And_Join_Switch = false;
        $Or_Split_Switch = false;
        $inward_arc_name = 'Unknown';
        foreach ($inwardArcObjArr as $inwardArcObj) {
            $inward_arc_name = $inwardArcObj->getName();
            if ($inwardArcObj->getArcType() == ArcTypeEnum::SEQ) {
                $SEQ = true;
            }
            elseif ($inwardArcObj->getArcType() == ArcTypeEnum::AND_JOIN) {
                $And_Join_Switch = true;
            }
            elseif ($inwardArcObj->getArcType() == ArcTypeEnum::OR_SPLIT) {
                $Or_Split_Switch = true;
            }
        }
        if ($SEQ && $And_Join_Switch) {
            throw new Exception_WorkFlow("WorkItem w/ mixed type arcs near " . $inward_arc_name . " Threw Exception" . __FILE__ . __LINE__);
        }
        if ($SEQ && $Or_Split_Switch) {
            throw new Exception_WorkFlow("WorkItem w/ mixed type arcs near " . $inward_arc_name . " Threw Exception" . __FILE__ . __LINE__);
        }
        if ($And_Join_Switch && $Or_Split_Switch) {
            throw new Exception_WorkFlow("WorkItem w/ mixed type arcs near " . $inward_arc_name . " Threw Exception" . __FILE__ . __LINE__);
        }
        if (!$SEQ && !$And_Join_Switch && !$Or_Split_Switch) {
            throw new Exception_WorkFlow("WorkItem w/ mixed type arcs near " . $inward_arc_name . " Threw Exception" . __FILE__ . __LINE__);
        }

        if($SEQ) return ArcTypeEnum::SEQ;
        if($And_Join_Switch) return ArcTypeEnum::AND_JOIN;
        if($Or_Split_Switch) return ArcTypeEnum::AND_JOIN;
        throw new Exception_WorkFlow("WorkItem w/ mixed type arcs near " . $inward_arc_name . " Threw Exception" . __FILE__ . __LINE__);
    }
}
