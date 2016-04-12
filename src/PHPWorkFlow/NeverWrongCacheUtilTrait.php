<?php

namespace PHPWorkFlow;

use PHPWorkFlow\Cache\Cache;

/**
 * Class TriggerFulfillmentTrait
 * @package PHPTriggerFulfillment
 * @codeCoverageIgnore
 */
trait NeverWrongCacheUtil
{
    static $CacheObj;

    /**
     * @static
     * @param $class
     * @param $function
     * @param $args
     * @param array $cache_partitions_arr
     * @return array|bool|mixed
     */
    public static function GenericCacheWrapperFetch($class, $function, $args, array $cache_partitions_arr, $callback)
    {
        if(Configuration_WorkFlow::getUseCache() && $ttl = $class::DAOCacheSwitch($function))
        {
            if(!self::$CacheObj)
            {
                self::$CacheObj = new Cache();
            }
            $key = $class.'_'.$function;
            foreach($args as $arg)
            {
                if(is_object($arg))
                {
                    $key .=  '__'.get_class($arg).'__'.$arg->get_id();
                }
                elseif(is_array($arg))
                {
                    $key .=  '__'.serialize($arg);
                }
                else
                {
                    $key .=  '__'.$arg;
                }
            }
            $CommonUtilObj = new CommonUtil();
            $key .=  '__'.$CommonUtilObj->roundToNearest($ttl,time()).Configuration_WorkFlow::getCacheUniqueKeySuffix();
            $thingToReturn  = self::$CacheObj->get($key);
            if($thingToReturn == '__false__')
            {
                return false;
            }
            elseif($thingToReturn == '__empty_array__')
            {
                return array();
            }

            if(! $thingToReturn)
            {
                //$thingToReturn = $callback($args);
                $thingToReturn = call_user_func_array ($callback , $args);
                if($thingToReturn === false)
                {
                    self::$CacheObj->set($key,'__false__', $cache_partitions_arr);
                }
                elseif(is_array($thingToReturn) && count($thingToReturn) == 0 )
                {
                    self::$CacheObj->set($key,'__empty_array__', $cache_partitions_arr);
                }
                else
                {
                    self::$CacheObj->set($key, $thingToReturn, $cache_partitions_arr);
                }
            }
            return $thingToReturn;
        }
        return call_user_func_array ($callback , $args);
    }

    /**
     * @param       $class
     * @param       $function
     * @param       $args
     * @param array $cache_partitions_arr
     * @param       $callback
     * @return mixed
     * @throws Exception_WorkFlow
     */
    public static
    function GenericCacheWrapperInsertUpdateDelete($class, $function, $args, array $cache_partitions_arr, $callback)
    {
        if(
            (! substr($function, 0, 5) == 'Fetch') &&
            (! substr($function, 0, 6) == 'Update') &&
            (! substr($function, 0, 6) == 'Delete')
        )
        {
            throw new Exception_WorkFlow('Invalid function '. $class.'::'.$function);
        }

        if(Configuration_WorkFlow::getUseCache())
        {
            if(!self::$CacheObj)
            {
                self::$CacheObj = new Cache();
            }
            //$thingToReturn = $callback($args);
            $thingToReturn = call_user_func_array ($callback , $args);
            self::$CacheObj->flush($cache_partitions_arr);
            return $thingToReturn;
        }
        return call_user_func_array ($callback , $args);
    }
}
