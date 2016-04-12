<?php

set_include_path ( __DIR__ );
require 'vendor/autoload.php';

// setup Propel
require_once \PHPWorkFlow\Configuration_WorkFlow::getPHPWORKFLOW_PROPEL_CONF();

use \Propel\Runtime\Propel;
\Propel::disableInstancePooling();
\PHPWorkFlow\Logger_WorkFlow::configure(PHPWorkFlow\Configuration_WorkFlow::getLog4PHPConfFileLocation());