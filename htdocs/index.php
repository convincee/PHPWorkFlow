<?php

require_once __DIR__.'/../PHPWorkFlow.init.php';
/**
 * define our application directory
 */
define('WORKFLOWAPP_DIR', PHPWORKFLOW_PATH_TO_ROOT . '/htdocs/WorkFlowApp/');
/**
 * define smarty lib directory
 */
define('SMARTY_DIR', PHPWORKFLOW_PATH_TO_ROOT . '/vendor/smarty/smarty/libs/');
/**
 * include the setup script
 */
require(WORKFLOWAPP_DIR . '/libs/WorkFlowApp_Smarty.php');

// create WorkFlowApp object
$workFlowAppObj = new WorkFlowApp;

// set the current action
$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';
$focus = isset($_REQUEST['focus']) ? $_REQUEST['focus'] : 'WorkFlow';

try {
    switch ($_action) {
        /**
         * WorkFlow
         */
        case 'addWorkFlow':
            $workFlowAppObj->displayWorkFlowForm();
            break;
        case 'deleteWorkFlow':
            $workFlowAppObj->deleteWorkFlow($_GET['WorkFlowId']);
            /* Redirect browser */
            header("Location: /index.php?focus=" . $focus);
            break;
        case 'submitWorkFlow':
            $workFlowAppObj->addWorkFlow($_FILES);
            /* Redirect browser */
            header("Location: /index.php?focus=" . $focus);
            break;
        case 'downloadPNML':
            $workFlowAppObj->generate_PNML($_GET);
            break;
        /**
         * UseCase
         */
        case 'deleteUseCase':
            $workFlowAppObj->deleteUseCase($_GET['UseCaseId']);
            /* Redirect browser */
            header("Location: /index.php?focus=" . $focus);
            break;
        case 'addUseCase':
            $workFlowAppObj->displayUseCaseForm();
            break;
        case 'submitUseCase':
            $workFlowAppObj->addUseCase($_POST);
            /* Redirect browser */
            header("Location: /index.php?focus=" . $focus);
            break;
        /**
         * WorkItem
         */
        case 'triggerWorkItem':
            $workFlowAppObj->triggerWorkItem($_GET);
            /* Redirect browser */
            header("Location: /index.php?focus=" . $focus);
            break;
        case 'pushUseCase':
            $workFlowAppObj->pushUseCase($_GET);
            /* Redirect browser */
            header("Location: /index.php?focus=" . $focus);
            break;
        /**
         * TriggerFulfillment
         */
        case 'addTriggerFulfillment':
            $workFlowAppObj->displayTriggerFulfillmentForm($_GET);
            break;
        case 'submitTriggerFulfillment':
            $workFlowAppObj->addTriggerFulfillment($_POST);
            /* Redirect browser */
            header('Location: /index.php?focus=' . $focus);
            break;
        case 'deleteTriggerFulfillment':
            $workFlowAppObj->deleteTriggerFulfillmentWithUseCaseIdAndTransitionTriggerMethod($_GET);
            /* Redirect browser */
            header('Location: /index.php?focus=' . $focus);
            break;

        /**
         * Default and Home Page
         */
        case 'view':
        default:
            // viewing the WorkFlowApp
            $workFlowAppObj->displayIndexPage($focus);
            break;
    }
} catch (\PHPWorkFlow\Exception_WorkFlow $exceptionObj) {
    echo $exceptionObj;
} catch (Exception $exceptionObj) {
    echo $exceptionObj->getMessage();
    echo $exceptionObj->getTraceAsString();
}