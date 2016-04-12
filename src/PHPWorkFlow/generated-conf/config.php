<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('PHPWorkFlow', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(
    array (
        'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
        'dsn' => 'mysql:host=localhost;dbname=PHPWorkFlow',
        'user' => 'PHPWorkFlow_user',
        'password' => 'W1sc0ns1n',
        'attributes' =>
        array (
            'ATTR_EMULATE_PREPARES' => false,
        ),
    )
);
$manager->setName('PHPWorkFlow');
$serviceContainer->setConnectionManager('PHPWorkFlow', $manager);
$serviceContainer->setDefaultDatasource('PHPWorkFlow');
