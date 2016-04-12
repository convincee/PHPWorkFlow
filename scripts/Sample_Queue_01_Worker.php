<?php
require_once __DIR__ . '/../PHPWorkFlow.init.php';

echo 'Starting ' . __File__ . PHP_EOL;

$rabbitMq = new \PHPWorkFlow\RabbitMQ_Workflow_Sample_Queue_01();
try{

    $rabbitMq->consumeTestMessages();
}
catch (Exception $ExceptionObj)
{
    if($ExceptionObj->getMessage() == 'shutdown')
    {
        print __FILE__ . ' ...Success via Shutdown' . PHP_EOL;
        exit(1);
    }
}
print __FILE__ . ' ...Success' . PHP_EOL;
exit(1);

