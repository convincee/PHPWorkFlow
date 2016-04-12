<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/**
 * WorkFlow
 */
$app->get('workflow', 'WorkFlowController@showWorkFlows');
$app->get('workflow/{work_flow_id}', 'WorkFlowController@showWorkFlowWithWorkFlowId');
$app->post('workflow/', 'WorkFlowController@createWorkFlow');
$app->delete('workflow/{work_flow_id}', 'WorkFlowController@deleteWorkFlow');

/**
 * UseCase
 */
$app->get('usecase', 'UseCaseController@showUseCases');
$app->get('usecase/{use_case_id}', 'UseCaseController@showUseCaseWithUseCaseId');
$app->post('usecase', 'UseCaseController@createUseCase');
$app->delete('usecase/{use_case_id}', 'UseCaseController@deleteUseCase');

/**
 * WorkItems
 */

$app->get('workitem', 'WorkItemController@showWorkItems');
$app->get('workitem/{work_item_id}', 'WorkItemController@showWorkItemWithWorkItemId');
$app->get('workitem/use_case_id/{use_case_id}', 'WorkItemController@showWorkItemsWithUseCaseId');
$app->get('workitem/work_item_status/{work_item_status}', 'WorkItemController@showWorkItemsWithWorkItemStatus');

/**
 * Token
 */
$app->get('token', 'TokenController@showTokens');
$app->get('token/{token_id}', 'TokenController@showTokenWithTokenId');
$app->get('token/use_case_id/{use_case_id}', 'TokenController@showTokensWithUseCaseId');
$app->get('token/token_status/{token_status}', 'TokenController@showTokensWithTokenStatus');


$app->get('triggerfulfillment', 'TriggerFulfillmentController@showTriggerFulfillment');
$app->get('triggerfulfillment/use_case_id/{use_case_id}', 'TriggerFulfillmentController@showTriggerFulfillmentWithUseCaseId');
$app->get('triggerfulfillment/use_case_status/{use_case_status}', 'TriggerFulfillmentController@showTriggerFulfillmentWithUseCaseStatus');
$app->post('triggerfulfillment', 'TriggerFulfillmentController@createTriggerFulfillment');
$app->delete('triggerfulfillment/{trigger_fulfillment_id}', 'TriggerFulfillmentController@deleteTriggerFulfillmentWithTriggerFulfillmentId');
$app->delete('triggerfulfillment/use_case_id/{use_case_id}', 'TriggerFulfillmentController@deleteTriggerFulfillmentWithUseCaseId');

