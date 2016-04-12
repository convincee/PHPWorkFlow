<?php

namespace PHPWorkFlow;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

/**
 * Class RabbitMQ_Workflow
 * @package PHPWorkFlow
 */
class RabbitMQ_Workflow
{
    /**RabbitMQ_Workflow_Test
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * RabbitMQ_Workflow constructor.RabbitMQ_Workflow_Test
     */
    public function __construct()
    {
        try
        {
            $conf = Configuration_WorkFlow::getRabbitMQConf();
            $this->connection = new AMQPStreamConnection(
                $conf['host'],
                $conf['port'],
                $conf['username'],
                $conf['password']
            );
        }
        catch(\Exception $ExceptionObj)
        {
            error_log('*****************RabbitMQ_Workflow***********************************************');
            error_log('****************************************************************');
            error_log('******* failures in TCP_RABBITMQ ************************************');
            error_log('******* unable to connect to RABBITMQ ******************************');
            error_log('****************************************************************');
            error_log('******* make sure that dbBuild was successful ******************');
            error_log('****************************************************************');
            error_log('******* probable cause of this crash is user  ******************');
            error_log('******* acct you tried to log into does not   ******************');
            error_log('******* exist in user table                   ******************');
            error_log('****************************************************************');
            error_log('****************************************************************');
            throw $ExceptionObj;
        }
    }

    public function closeConnection()
    {
        $this->connection->close();
    }

    /**
     * @param $queue
     * @param $exchange
     * @param $arrPayload
     */
    public function sendMessage($queue, $arrPayload)
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($queue, false, true, false, false);
        $msg = new AMQPMessage(
            json_encode($arrPayload),
            [
                'delivery_mode' => 2,
                'content_type' => 'text/plain'
            ]
        );
        $channel->basic_publish($msg,'',$queue);
        $channel->close();
    }

    /**
     * @param $queue
     * @param $callback
     */
    public function consumeMessages($queue,$callback)
    {
        $channel = $this->connection->channel();

        $channel->queue_declare($queue, false, true, false, false);

        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($queue, '', false, false, false, false, $callback);

        while(count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
    }




}