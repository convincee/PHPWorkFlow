<?php
require(WORKFLOWAPP_DIR . 'libs/WorkFlowApp.php');
require(SMARTY_DIR . 'Smarty.class.php');

/**
 * smarty configuration
 *
 * Class WorkFlowApp_Smarty
 */
class WorkFlowApp_Smarty extends \Smarty
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct();
        $this->setTemplateDir(WORKFLOWAPP_DIR . 'templates');
        $this->setCompileDir(WORKFLOWAPP_DIR . 'templates_c');
        $this->setConfigDir(WORKFLOWAPP_DIR . 'configs');
        $this->setCacheDir(WORKFLOWAPP_DIR . 'cache');
    }
}