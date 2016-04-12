<?php
namespace PHPWorkFlow\Cache;

/**
 * Class StaticStore
 * @codeCoverageIgnore
 */
class StaticStore {

    /*
     * time-to-live default: 30min
     */
    const TTL = 1800;
    /*
     * compress when payload has more bytes than this
     */
	const SIZE_MIN = 2000;
    /*
     * compress when savings is greater than this percentage
     */
	const SAVE_MIN = .25;

    /**
     * @var
     */
	protected static $Instance;
    /**
     * @var StaticStore
     */
	protected static $Memcache;
    /**
     * @var int
     */
	protected static $ttl;
    /**
     * @var array
     */
    protected static $cacheStore = [];

    protected function __construct()
    {
        self::$cacheStore = array();
    }

    /**
     * @static
     * @param int $ttl
     * @param int $size_min
     * @param float $save_min
     * @return StaticStore
     */
    public static
    function init(
        $ttl = self::TTL,
        $size_min = self::SIZE_MIN,
        $save_min = self::SAVE_MIN)
	{
		return self::$Instance
			? self::$Instance
			: self::$Instance = new StaticStore((array) $ttl, $size_min, $save_min);
	}

    /**
     * @throws Exception
     * @return void
     */
    public
    function __clone()
    {
        throw new Exception('Clone is not allowed');
    }

    /**
     * @param  $key
     * @param  $flags
     * @return bool
     */
    public
    function get($key, &$flags=[])
    {
        if(! isset(self::$cacheStore[$key]))
        {
            return false;
        }
        return self::$cacheStore[$key];
    }

    /**
     * @param  $key
     * @param  $data
     * @param  $flags
     * @return void
     */
    public
    function set($key, $data, &$flags=[])
    {
        self::$cacheStore[$key] = $data;
    }

    /**
     * @return void
     */
    public
    function flush()
    {
        self::$cacheStore = [];
    }

    /**
     * @return int
     */
    function get_cache_store_size()
    {
        return strlen(serialize(self::$cacheStore));
    }
}
