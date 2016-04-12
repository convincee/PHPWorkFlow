<?php

namespace PHPWorkFlow;

/**
 * Class RabbitMQ_Workflow_Sample_Worker_01
 * @package PHPWorkFlow
 */
class RabbitMQ_Workflow_Sample_Queue_01 extends RabbitMQ_Workflow
{
    const MessageQueueName = "Sample_Queue_01_Message";
    const ErrorQueueName = "Sample_Queue_01_Error";
    /**
     * RabbitMQ_Workflow constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $payload
     */
    public function sendTestMessage($payload) {
        $this->sendMessage(
            self::MessageQueueName,
            $payload
        );
    }

    /**
     * @param $payload
     */
    public function sendTestShutdownMessage($payload, $numberOfMessages=10) {
        for ($counter = 0; $counter < $numberOfMessages; $counter++) {
            $this->sendMessage(
                self::MessageQueueName,
                $payload
            );
        }
    }

    /**
     * @param $payload
     */
    public function sendFailedTestMessage($payload) {
        $this->sendMessage(
            self::ErrorQueueName,
            $payload
        );
    }

    public function consumeTestMessages() {
        $callback = function($msg){
            if($msg->body == '"shutdown"'){
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
                throw new \Exception('shutdown');
            }
            /**
             * Start - insert your code here to do the thing this worker does
             * using $msg
             */

            echo " [x] Received ", $msg->body, "\n";
            sleep(substr_count($msg->body, '5'));

            echo " [x] Done", "\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);

            /**
             * End - insert your code here
             */

        };

        $this->consumeMessages(self::MessageQueueName, $callback);
    }
}
