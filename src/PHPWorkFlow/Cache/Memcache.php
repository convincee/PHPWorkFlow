<?php
namespace PHPWorkFlow\Cache;

use PHPWorkFlow\Configuration_WorkFlow;
use PHPWorkFlow\Exception_WorkFlow;

/**
 * Class Memcache
 * @codeCoverageIgnore
 */
class Memcache
{
	protected static $Instance;
    /**
     * @var \Memcache
     */
	protected static $MemcacheObj;

    /**
     * @static
     * @return Memcache
     */
	public static function init()
	{
        $MEMCACHE = Configuration_WorkFlow::getMemcacheConf();

        if(is_array($MEMCACHE['memcache_host']))
        {
            $hosts = $MEMCACHE['memcache_host'];
        }
        elseif(isset($MEMCACHE['memcache_host']))
        {
            $hosts = [$MEMCACHE['memcache_host']];
        }
        else
        {
            throw new Exception_WorkFlow('bad getMemcacheConf');
        }
        $ttl = $MEMCACHE['memcache_ttl'];
        $size_min = $MEMCACHE['memcache_size_min'];
        $save_min = $MEMCACHE['memcache_save_min'];

		return self::$Instance
			? self::$Instance
			: self::$Instance = new Memcache((array) $hosts, $ttl, $size_min, $save_min);
	}

    /**
     * initialize the memcache connection with default options
     * @param array $hostArr
     * @param       $ttl
     * @param       $size_min
     * @param       $save_min
     * @throws \PHPWorkFlow\Exception_WorkFlow
     */
	protected function __construct(array $hostArr, $ttl, $size_min, $save_min)
	{
		if(empty($hostArr))
        {
			throw new \PHPWorkFlow\Exception_WorkFlow('missing memcache host(s)');
		}
		self::$MemcacheObj = new \Memcached();
		foreach($hostArr as $host)
        {
			self::$MemcacheObj->addserver($host, 11211)
				or trigger_error('failed to add memcache host $h', E_USER_NOTICE);
		}
		if(0 && extension_loaded('zlib'))
        {
            try{
                self::$MemcacheObj->setCompressThreshold($size_min);
            }
            catch (\Exception $e)
            {
                throw $e;
            }
		}
	}

    /**
     * @param  $key
     * @param  $val
     * @param null $expiry
     * @return void|bool
     */
    public
    function set($key, $val, $expiry=null)
    {
        if ($expiry === null)
        {
            $MEMCACHE = Configuration_WorkFlow::getMemcacheConf();
            if(isset($MEMCACHE['memcache_ttl']) && $MEMCACHE['memcache_ttl'])
            {
                $expiry = $MEMCACHE['memcache_ttl'];
            }
            else
            {
                $expiry = 3600;
            }
        }

        return self::$MemcacheObj->set($key, $val,0, $expiry);
    }

	/**
	 * magic method to pass-thru all methods of the native Memcache class
	 *
	 * Note: add/set/replace methods are modified so that the parameters are just
	 * key, value and optional expiry. the compress flag parameter is ignored, and
	 * null is used.
	 *
	 * @example
	 *   $this->add($key, $val, $expiry);
	 *   $this->set($key, $val, $expiry);
	 *   $this->replace($key, $val, $expiry);
	 *
	 *  all other methods calls are passed thru to PHP's native Memcache class.
     * @param $method
     * @param array $args
     * @return mixed
     */
	public
    function __call($method, array $args)
	{
		if(in_array($method, array('add', 'set', 'replace'))) {
            $MEMCACHE = Configuration_WorkFlow::getMemcacheConf();
			$args = array($args[0], $args[1], null, isset($args[2]) ? $args[2] : $MEMCACHE['memcache_ttl']);
		}
        $returnMe = call_user_func_array(array(self::$MemcacheObj, $method), $args);
		return $returnMe;
	}

    /**
     * @return array|bool
     */
    public
    function getstats()
    {
        return self::$MemcacheObj->getstats();
    }

    /**
     * @return array|bool
     *
     */
    public function getextendedstats()
    {
        return self::$MemcacheObj->getextendedstats();
    }

    /**
     * @return array|bool
     */
    public  function get_cache_store_size()
    {
        $returnMe = self::$MemcacheObj->getstats();
        return $returnMe;
    }

}
