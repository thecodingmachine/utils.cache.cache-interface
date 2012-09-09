Mouf Cache system
=================

The Mouf framework is only an IOC framework. As such, it does not provide any means for managing any kind of cache. Hopefully, the Mouf team provides also a range of packages to manage the caching of objects.

The cache architecture
----------------------

Mouf provides several implementations of caching, and you can provide your own if you want.
Each cache mechanism must just extend the <code>CacheInterface</code> interface that is part of the
package utils/cache/cacheinterface.

By default, Mouf provides these caches:

 - <b>FileCache</b>: a cache that writes cached elements in files, in a temporary folder.</li>
 - <b>SessionCache</b>: a cache that writes cached elements in the session of the current user. Therefore, this cache is local to a user.</li>
 - <b>ApcCache</b>: a cache that uses the APC extension to store data.</li>
 - <b>NoCache</b>: a cache that... does not provide any cache. Can be useful for development purpose.</li>


The cache methods
-----------------

Each class implementing the CacheInterface provides simple methods to get and set data in the cache:
```php
interface CacheInterface {
	/**
	 * Returns the cached value for the key passed in parameter.
	 *
	 * @param string $key
	 * @return mixed
	 */
	function get($key);
	
	/**
	 * Sets the value in the cache.
	 *
	 * @param string $key The key of the value to store
	 * @param mixed $value The value to store
	 * @param int $timeToLive The time to live of the cache, in seconds.
	 */
	function set($key, $value, $timeToLive = null);
	
	/**
	 * Removes the object whose key is $key from the cache.
	 *
	 * @param string $key The key of the object
	 */
	function purge($key);
	
	/**
	 * Removes all the objects from the cache.
	 *
	 */
	function purgeAll();
}
```


For instance, to store some value in the cache, you just need to write:

```php
$cache->set("mykey", "myvalue", 15);
```

This will store the value "myvalue" in the cache, with key "mykey". The value will be stored for 15 seconds.
If within 15 seconds, we perform a call to retrieve the cache, the value will be retrieved:

```php
// Will print "myvalue" if called within 15 seconds.
echo $cache->get("mykey");
```

The third parameter is optional. If not passed, the default value will be used. The default value is "forever", which means the
cached value will never time out. The default value can be overidden in the Mouf cache instance properties.