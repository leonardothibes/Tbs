<?php
/**
 * @package \Tbs\Cache
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Cache\Interfaces;

/**
 * Cacheable Interface.
 *
 * @package \Tbs\Cache
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
interface CacheableInterface
{
    /**
     * Set the cache driver.
     *
     * @param string $driver   Name of driver(apc, memcached...).
     * @param array  $frontend Frontend options of driver.
     * @param array  $backend  Backend options of driver.
     *
     * @return CacheableInterface
     */
    public function setCacheDriver($driver = 'apc', array $frontend = array(), array $backend = array());

    /**
     * Get the cache driver.
     * @return string
     */
    public function getCacheDriver();

    /**
     * Delete a cache value.
     *
     * @param  string $id Cache id.
     * @return Cacheable
     */
    public function remove($id = null);

    /**
     * Alias for remove.
     *
     * @param  string $id Cache id.
     * @return Cacheable
     */
    public function delete($id = null);

    /**
     * Clear all the cache values.
     * @return CacheableInterface
     */
    public function clear();
}
