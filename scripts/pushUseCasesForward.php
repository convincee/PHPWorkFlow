<?php

namespace PHPWorkFlow;

use PHPWorkFlow\Enum\UseCaseStatusEnum;

require_once __DIR__.'/../PHPWorkFlow.init.php';
$workFlowDAO = new WorkFlowDAO();
/**
 * push all useCases
 */
$workFlowTraffickerObj = new WorkFlowTrafficker();
$workFlowTraffickerObj->checkWorkItemsForCompleteness();

/**
 * push by useCase
 */
foreach($workFlowDAO->FetchUseCaseArrWithUseCaseStatus(UseCaseStatusEnum::OPEN) as $useCaseObj)
{
    $workFlowTraffickerObj = new WorkFlowTrafficker(null, $useCaseObj->getUseCaseId());
    $workFlowTraffickerObj->checkWorkItemsForCompleteness();
}

/**
 * push by route
 */
foreach($workFlowDAO->FetchTransitionArr() as $transitionObj)
{
    foreach($transitionObj->getRoutes() as $routeObj)
    {
        $workFlowTraffickerObj = new WorkFlowTrafficker($routeObj->getRoute(), null);
        $workFlowTraffickerObj->checkWorkItemsForCompleteness();
    }
}


/**
 * push by route and $useCaseObj
 */
foreach($workFlowDAO->FetchUseCaseArrWithUseCaseStatus(UseCaseStatusEnum::OPEN) as $useCaseObj)
{
    foreach($useCaseObj->getWorkFlow()->getTransitions() as $transitionObj)
    {
        foreach($transitionObj->getRoutes() as $routeObj)
        {
            $workFlowTraffickerObj = new WorkFlowTrafficker($routeObj->getRoute(), $useCaseObj->getUseCaseId());
            $workFlowTraffickerObj->checkWorkItemsForCompleteness();
        }
    }
}
