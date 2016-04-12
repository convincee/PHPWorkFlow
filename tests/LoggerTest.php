<?php

require_once __DIR__.'/../PHPWorkFlow.init.php';

use \PHPWorkFlow\Logger_WorkFlow;

/**
 * Class WorkFlowTest
 *
 * @backupGlobals          disabled
 * @backupStaticAttributes disabled
 * @codeCoverageIgnore
 */
class LoggerTest extends PHPWorkFlow_Framework_TestCase_Integration
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        foreach (Logger_WorkFlow::getLoggers() as $logger) {
            $log_file_name = Logger_WorkFlow::get_Log4PHP_ConfFileLocationForLogger($logger);
            if (file_exists($log_file_name)) {
                unlink($log_file_name);
                touch($log_file_name);
            }
        }
    }

    /**
     * @return \PHPWorkFlow\DB\WorkFlow
     * @throws Exception
     * @throws \PHPWorkFlow\Exception_WorkFlow
     * @todo         read log files
     * @dataProvider loggerStringsProvider
     */
    public function testLoggerException($log_level, $log_string, $logger)
    {
        $log_file_name = Logger_WorkFlow::get_Log4PHP_ConfFileLocationForLogger($logger);
        $e = new Exception($log_string);
        \PHPWorkFlow\Logger_WorkFlow::$log_level($e, $logger);
        $plaintext = file_get_contents($log_file_name);
        $this->assertContains($log_string, $plaintext);
    }

    /**
     * @return \PHPWorkFlow\DB\WorkFlow
     * @throws Exception
     * @throws \PHPWorkFlow\Exception_WorkFlow
     * @todo         read log files
     * @dataProvider loggerStringsProvider
     */
    public function testLoggerExceptionWorkFlow($log_level, $log_string, $logger)
    {
        $log_file_name = Logger_WorkFlow::get_Log4PHP_ConfFileLocationForLogger($logger);
        $e = new \PHPWorkFlow\Exception_WorkFlow($log_string);
        \PHPWorkFlow\Logger_WorkFlow::$log_level($e, $logger);
        $plaintext = file_get_contents($log_file_name);
        $this->assertContains($log_string, $plaintext);
    }

    /**
     * @param $log_level
     * @param $log_string
     * @param $logger
     * @throws \PHPWorkFlow\Exception_WorkFlow
     * @dataProvider loggerStringsProvider
     */
    public function testLoggerStrings($log_level, $log_string, $logger)
    {
        $log_file_name = Logger_WorkFlow::get_Log4PHP_ConfFileLocationForLogger($logger);
        \PHPWorkFlow\Logger_WorkFlow::$log_level($log_string, $logger);
        $plaintext = file_get_contents($log_file_name);
        $this->assertContains($log_string, $plaintext);
    }

    /**
     * @return array
     */
    public function loggerStringsProvider()
    {
        $returnMe = [];
        $guid_for_this_test = $this->guid();

        $loggers_available = \PHPWorkFlow\Logger_WorkFlow::getLoggers();
        $loggers_available[] = null;
        foreach ($loggers_available as $logger) {
            foreach (\PHPWorkFlow\Logger_WorkFlow::getLogLevels() as $log_level) {
                $returnMe[] = [$log_level, $log_level . ' ' . $guid_for_this_test, $logger];
            }
        }
        return $returnMe;
    }
}