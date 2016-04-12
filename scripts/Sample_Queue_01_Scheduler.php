<?php
require_once __DIR__ . '/../PHPWorkFlow.init.php';

echo 'Starting ' . __File__ . PHP_EOL;

$rabbitMq = new \PHPWorkFlow\RabbitMQ_Workflow_Sample_Queue_01();
$x = 0;
while(1){
    $rabbitMq->sendTestMessage(
        json_encode(
            [
                'var1' => rand(),
                'var2' => rand(),
                'var3' => rand()
            ]
        )
    );
    if($x++ > 10000)
    {
        $rabbitMq->sendTestMessage(
            'shutdown'
        );
        $x=0;
    }


}
print __FILE__ . ' ...Success' . PHP_EOL;
exit(1);

