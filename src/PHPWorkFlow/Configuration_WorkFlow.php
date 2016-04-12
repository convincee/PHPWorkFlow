<?php
namespace PHPWorkFlow;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Configuration_WorkFlow
 * @package PHPWorkFlow
 *
 * @method static getWriteLogsToSysout()
 * @method static setWriteLogsToSysout($value)
 *
 * @method static getPHPWORKFLOW_PROPEL_CONF()
 * @method static setPHPWORKFLOW_PROPEL_CONF($value)
 *
 * @method static getLog4PHPConfFileLocation()
 * @method static setLog4PHPConfFileLocation($value)
 *
 * @method static getEnvironment()
 * @method static setEnvironment($value)
 *
 * @method static getPHPWORKFLOW_MEMCACHE_CONFIG()
 * @method static setPHPWORKFLOW_MEMCACHE_CONFIG($value)
 *
 * @method static getPHPWORKFLOW_RABBIT_CONFIG()
 * @method static setPHPWORKFLOW_RABBIT_CONFIG($value)
 *
 *
 */
class Configuration_WorkFlow
{
    private static $PHPWorkFlow_conf = [];

    /**
     * @return array
     * @throws \Exception
     */
    public static function getPHPWorkFlowConf()
    {
        try {
            if (!self::$PHPWorkFlow_conf) {
                self::$PHPWorkFlow_conf = Yaml::parse(file_get_contents('PHPWorkFlow.yml'));
            }
            return self::$PHPWorkFlow_conf;
        } catch (\Exception $Exception) {
            throw $Exception;
        }
    }

    /***********************************************/

    public static function __callStatic($name, $arguments)
    {
        try {
            if (substr($name, 0, 3) === 'set') {
                if (!array_key_exists(self::getPHPWorkFlowConf(), substr($name, 3))) {
                    throw new Exception_WorkFlow('no such conf var as ' . substr($name, 3));
                }
                self::$PHPWorkFlow_conf[$name] = $arguments[0];
                return true;
            }

            return self::getPHPWorkFlowConf()[$name];
        } catch (\Exception $exceptionObj) {
            throw new \Exception('failed  $name ' . substr($name, 3));
        }
    }

    protected static $MemcacheConf;

    /**
     * @return mixed
     * @throws Exception_WorkFlow
     */
    public static function getMemcacheConf()
    {
        try {
            if (!self::$MemcacheConf) {
                /*
                 * Setup Memache to always load from file
                */
                $memcache_conf_arr = Yaml::parse(file_get_contents(self::getMemcacheConfFile()));
                self::$MemcacheConf = $memcache_conf_arr[self::getEnvironment()];
            }
            return self::$MemcacheConf;
        } catch (\Exception $Exception) {
            throw new Exception_WorkFlow($Exception->getMessage());
        }
    }

    protected static $memcache_conf_file;

    /**
     * @return bool
     */
    public static function getMemcacheConfFile()
    {
        if (!self::$memcache_conf_file) {
            self::setMemcacheConfFile(self::getPHPWORKFLOW_MEMCACHE_CONFIG());
        }
        return self::$memcache_conf_file;
    }

    /**
     * @return bool
     */
    public static function setMemcacheConfFile($memcache_conf_file)
    {
        self::$memcache_conf_file = $memcache_conf_file;
        return self::$memcache_conf_file;
    }

    /***********************************************/

    private static $rabbitMQConf;

    /**
     * @return bool
     */
    public static function getRabbitMQConf()
    {
        if (!static::$rabbitMQConf) {
            self::setRabbitMQConf();
        }
        return static::$rabbitMQConf;
    }

    /**
     * @param null $rabbitMQConf
     */
    public static function setRabbitMQConf($rabbitMQConf = null)
    {
        if ($rabbitMQConf) {
            self::$rabbitMQConf = $rabbitMQConf;
        } else {
            $rabbitMQConf_all_enviroments = Yaml::parse(file_get_contents(self::getPHPWORKFLOW_RABBIT_CONFIG()));
            static::$rabbitMQConf = $rabbitMQConf_all_enviroments[self::getEnvironment()];
        }
    }
}
