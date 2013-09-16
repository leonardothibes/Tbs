<?php
/**
 * @package Tbs\ZfComponents\V1\Cache
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\ZfComponents\V1\Cache;

use \Tbs\Cache\Interfaces\CacheableInterface;

/**
 * Abstract class for all models implements some cache.
 *
 * @package Tbs\ZfComponents\V1\Cache
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class CacheAbstraction extends \Zend_Cache implements CacheableInterface
{
    /**
     * Cache object.
     * @var Zend_Cache_Backend_ExtendedInterface
     */
    protected $cache = null;

    /**
     * Cache driver name.
     * @var string
     */
    protected $cacheDriver = null;

    /**
     * Set the cache driver.
     *
     * @param string $driver   Name of driver(apc, memcached...).
     * @param array  $frontend Frontend options of driver.
     * @param array  $backend  Backend options of driver.
     *
     * @return CacheableInterface
     */
    public function setCacheDriver($driver = 'apc', array $frontend = array(), array $backend = array())
    {
        $this->cacheDriver                   = (string)$driver;
        $frontend['caching']                 = true;
        $frontend['automatic_serialization'] = true;
        $this->cache = $this->factory('Core', $this->cacheDriver, $frontend, $backend);
    }

    /**
     * Get the cache driver.
     * @return string
    */
    public function getCacheDriver()
    {
        return (string)$this->cacheDriver;
    }

    /**
     * Clear cache value.
     *
     * @param  string $id Cache id.
     * @return Cacheable
    */
    public function clear($id = null)
    {
        $this->cache->remove((string)$id);
        return $this;
    }

    /**
     * Clear all the cache values.
     * @return CacheableInterface
    */
    public function clearAll()
    {
        $this->cache->clean(\Zend_Cache::CLEANING_MODE_ALL);
        return $this;
    }
}
