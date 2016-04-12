<?php
namespace PHPWorkFlow;

require_once('vendor/apache/log4php/src/main/php/Logger.php');
/**
 * Class Logger_WorkFlow
 *
 * NOTE - NOTE To redirect log output, update the STATIC Configuration_WorkFlow:$WRITE_LOGS_TO_SYSOUT to TRUE
 * NOTE - NOTE This is handy for unit-tests
 * http://logging.apache.org/log4php/quickstart.html
 *       Levels
 *
 *      A level describes the severity of a logging message. There are six levels, show here in descending order of severity.
 *      Level    Severity    Description
 *      FATAL    Highest    Very severe error events that will presumably lead the application to abort.
 *      ERROR    ...         Error events that might still allow the application to continue running.
 *      WARN    ...        Potentially harmful situations which still allow the application to continue running.
 *      INFO    ...        Informational messages that highlight the progress of the application at coarse-grained level.
 *      DEBUG    ...        Fine-grained informational events that are most useful to debug an application.
 *      TRACE    Lowest        Finest-grained informational events.
 *
 */

/**
 * Class Logger_WorkFlow
 * @package PHPWorkFlow
 * @todo add fingerprints
 */
class Logger_WorkFlow
{
    /**
     * The various loggers we support
     * always of format LOGGER_XXXXXXX
     */
    const LOGGER_WORKFLOW = 'workflow';
    const LOGGER_WORKFLOW_TRIGGER = 'workflowtrigger';

    /**
     * always of format SEVERITY_XXXXXX
     */
    const SEVERITY_TRACE = 'trace';
    const SEVERITY_DEBUG = 'debug';
    const SEVERITY_INFO = 'info';
    const SEVERITY_WARN = 'warn';
    const SEVERITY_ERROR = 'error';
    const SEVERITY_FATAL = 'fatal';

    static $default_logger = self::LOGGER_WORKFLOW;

    static function trace()
    {
        self::logMessage(func_get_args(), 'trace');
    }

    static function debug()
    {
        self::logMessage(func_get_args(), 'debug');
    }

    static function info()
    {
        self::logMessage(func_get_args(), 'info');
    }

    static function warn()
    {
        self::logMessage(func_get_args(), 'warn');
    }

    static function error()
    {
        self::logMessage(func_get_args(), 'error');
    }

    static function fatal()
    {
        self::logMessage(func_get_args(), 'fatal');
    }

    /**
     * @todo - I can't believe this doesn't work in base log4php
     * @todo - this will need work if anyone want to get fancy log4php conf
     *
     * @param $logger_name
     * @return string
     * @throws Exception_WorkFlow
     */
    static function get_Log4PHP_ConfFileLocationForLogger($logger_name)
    {
        $log4PHP_ConfContents = file_get_contents(Configuration_WorkFlow::getLog4PHPConfFileLocation());
        $lRootElement = new \SimpleXMLElement($log4PHP_ConfContents);
        $loggerNode = null;
        foreach($lRootElement->logger as $loggerNode)
        {
            if($loggerNode->attributes()['name'] == $logger_name)
            {
                break;
            }
        }
        $appender_name = (string) $loggerNode->appender_ref[0]->attributes()['ref'];
        foreach($lRootElement->appender as $appenderNode)
        {
            if($appenderNode->attributes()['name'] == $appender_name)
            {
                return (string) $appenderNode->param[0]->attributes()['value'];
            }
        }
        throw new Exception_WorkFlow('cannot find or process Log4PHP_ConfFileLocation');
    }

    /**
     * @param $args
     *      $args[0] - Exception_WorkFlow, Exception or string (required)
     *      $args[1] - $logger_in_question - default self::LOGGER_WORKFLOW (optional
     *      $args[2] - json string
     * @param $level
     * @todo clean this up a bit
     */
    private static function logMessage($args, $level)
    {
        $logger_in_question = self::arrayPlucker($args, 1, self::$default_logger);
        if ($args[0] instanceof Exception_WorkFlow) {
            /** @var Exception_WorkFlow $exception */
            $exception = $args[0];
            $message  = date("Y-m-d\TH:i:s-p T", time());
            $message .= ' ll=' . strtoupper($level) . ' ';
            $message .= self::formatException($exception);
        } elseif ($args[0] instanceof \Exception) {
            /** @var \Exception $exception */
            $exception = $args[0];
            $message  = date("Y-m-d\TH:i:s-p T", time());
            $message .= ' ll=' . strtoupper($level) . ' ';
            $message .= self::formatException($exception);
            \Logger::getLogger($logger_in_question)->$level($message);
            return;
        } else {
            if (Configuration_WorkFlow::getWriteLogsToSysout()) {
                echo date("Y-m-d\TH:i:s-p T", time()) .
                    ' ll=' . strtoupper($level) . ' ' .
                    $args[0], self::arrayPlucker($args, 2, null);
                return;
            }
            $message = date("Y-m-d\TH:i:s-p T", time()) . ' ll=' . strtoupper($level) . ' ' . $args[0];
        }

        if (Configuration_WorkFlow::getWriteLogsToSysout()) {
            echo $message;
        }
        else{
            \Logger::getLogger($logger_in_question)->$level($message);
        }
    }

    /**
     * @param $array
     * @param $index
     * @param $default
     * @return mixed
     * is set return else
     */
    static public function arrayPlucker($array, $index, $default)
    {
        if (isset($array[$index])) {
            return $array[$index];
        } else {
            return $default;
        }
    }

    /**
     * @param \Exception $e
     * @return string
     */
    static private function formatException(\Exception $e)
    {
        return
            "\tException of type " . get_class($e) . ' code = ' . $e->getCode() .
            PHP_EOL . "\t" . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine() .
            PHP_EOL . "\t" . 'Stack Trace:' .
            PHP_EOL . "\t" . str_replace("\n", PHP_EOL . "\t", $e->getTraceAsString());
    }

    /**
     * @return array
     */
    public static function getLogLevels()
    {
        $values = [];
        $reflectionObj = new \ReflectionClass(get_called_class());
        foreach($reflectionObj->getConstants() as $constant => $value)
        {
            if(substr($constant,0,8) == 'SEVERITY')
            {
                $values[] = $value;
            }
        }
        return $values;
    }

    /**
     * @return array
     */
    public static function getLoggers()
    {
        $values = [];
        $reflectionObj = new \ReflectionClass(get_called_class());
        foreach($reflectionObj->getConstants() as $constant => $value)
        {
            if(substr($constant,0,6) == 'LOGGER')
            {
                $values[] = $value;
            }
        }
        return $values;
    }

    /**
     * @param null $configuration
     * @param null $configurator
     */
    public static function configure($configuration = null, $configurator = null) {
        \Logger::configure($configuration, $configurator);
    }
}
