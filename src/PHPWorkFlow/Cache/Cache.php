<?php

namespace PHPWorkFlow\Cache;

use PHPWorkFlow\Configuration_WorkFlow;
use PHPWorkFlow\Exception_WorkFlow;

/**
 * Class Cache
 * @package PHPWorkFlow\Cache
 * @codeCoverageIgnore
 */
class Cache
{
    /**
     * @var \PHPWorkFlow\Cache\Memcache
     */
    private $CachingMechanismObj = null;
    /**
     * @var int
     */
    private static $totalHits = 0;
    /**
     * @var int
     */
    private static $totalMisses = 0;
    /**
     * @var int
     */
    private static $totalSets = 0;

    /**
     *
     */
    public function __construct()
    {
        if(Configuration_WorkFlow::getCachingMethod() == \PHPWorkFlow\Enum\CacheMethodEnum::MEMCACHE)
        {
            $this->CachingMechanismObj = Memcache::init();
        }
        elseif(Configuration_WorkFlow::getCachingMethod() == \PHPWorkFlow\Enum\CacheMethodEnum::STATIC_STORE)
        {
            $this->CachingMechanismObj = StaticStore::init();
        }
    }

    /**
     * @param $key
     * @return mixed
     * @throws Exception_WorkFlow
     */
    public
    function get($key)
    {
        $serializeVersion = $this->CachingMechanismObj->get($key);

        if(is_array($serializeVersion))
        {
            throw new Exception_WorkFlow('ABEND');
        }
        $returnData =  unserialize($serializeVersion);

        if ($returnData)
        {
            self::$totalHits++;
        }
        else
        {
            self::$totalMisses++;
        }
        return $returnData;
    }

    /**
     * @param  $key
     * @param  $data
     * @param array $cache_partitions_arr
     * @return bool
     */
    public
    function set($key, $data, $cache_partitions_arr = [])
    {
        $serializeVersion = serialize($data);
        $this->CachingMechanismObj->set($key, $serializeVersion);
        self::$totalSets++;
        /*
         * now that we have added '$key' to Mamcache store, we need to retrieve, update and set the
         * cache list for each table listed in $MySQLTables
         */
        foreach ($cache_partitions_arr as $mySQL_table)
        {
            $localKey = 'CacheTableToKeyCrossRef_'.$mySQL_table.Configuration_WorkFlow::getCacheUniqueKeySuffix();
            $cache_to_table_cross_ref_arr = $this->get($localKey);
            if(! $cache_to_table_cross_ref_arr)
            {
                $cache_to_table_cross_ref_arr = [];
            }
            if(in_array($key, $cache_to_table_cross_ref_arr))
            {
                return;
            }
            $cache_to_table_cross_ref_arr[] = $key;
            $this->CachingMechanismObj->set($localKey, serialize($cache_to_table_cross_ref_arr));
            self::$totalSets++;
        }
    }

    /**
     * @return bool
     * @param array $cache_partition_arr
     */
    public
    function flush(array $cache_partition_arr = [])
    {
        if(!Configuration_WorkFlow::getUseCache()){return true;}
        if(is_array($cache_partition_arr) && count($cache_partition_arr))
        {
            foreach($cache_partition_arr as $cache_partition)
            {
                $cross_reference_key = 'CacheTableToKeyCrossRef_'.$cache_partition.Configuration_WorkFlow::getCacheUniqueKeySuffix();
                $cache_to_table_cross_ref_arr = $this->get($cross_reference_key);

                if($cache_to_table_cross_ref_arr === false)
                {
                    /*
                     * this probably means that we have never cached a key in $cache_partition since full flush
                     * or system reset. Just init it and carry on
                     */
                    $this->CachingMechanismObj->set($cross_reference_key, serialize([]));
                    continue;
                }
                if(!is_array($cache_to_table_cross_ref_arr))
                {
                    throw new Exception_WorkFlow('ABEND');
                }
                if(count($cache_to_table_cross_ref_arr))
                {
                    foreach($cache_to_table_cross_ref_arr as $cache_to_table_cross_ref)
                    {
                        $this->CachingMechanismObj->set($cache_to_table_cross_ref, false);
                    }
                    $this->CachingMechanismObj->set($cross_reference_key, serialize([]));
                }
            }
            return true;
        }
        /*
         * if an empty or no $cache_partitions_arr is passed, flush everything
         */
        return $this->CachingMechanismObj->flush();
    }

    /**
     * @return int
     */
    public
    function get_hits()
    {
        if(!Configuration_WorkFlow::getUseCache()){return 0;}
        return self::$totalHits;
    }

    /**
     * @return int
     */
    public
    function get_misses()
    {
        if(!Configuration_WorkFlow::getUseCache()){return 0;}
        return self::$totalMisses;
    }

    /**
     * @return int
     */
    public
    function get_sets()
    {
        if(!Configuration_WorkFlow::getUseCache()){return 0;}
        return self::$totalSets;
    }

    /**
     * @return int
     */
    public
    function get_cache_hit_ratio()
    {
        if(!Configuration_WorkFlow::getUseCache()){return -1;}
        if (!(self::$totalMisses+self::$totalHits)){
            return -1;
        }
        return self::$totalHits/(self::$totalMisses+self::$totalHits);
    }

    /**
     * @return int|void
     */
    public
    function get_cache_store_size()
    {
        if(!Configuration_WorkFlow::getUseCache()){return 0;}
        return $this->CachingMechanismObj->get_cache_store_size();
    }

    /**
     * @return int|void
     */
    public
    function getstats()
    {
        if(!Configuration_WorkFlow::getUseCache()){return 0;}
        return $this->CachingMechanismObj->getstats();
    }

    /**
     * @return int|void
     */
    public
    function getextendedstats()
    {
        if(!Configuration_WorkFlow::getUseCache()){return 0;}
        return $this->CachingMechanismObj->getextendedstats();
    }

}
