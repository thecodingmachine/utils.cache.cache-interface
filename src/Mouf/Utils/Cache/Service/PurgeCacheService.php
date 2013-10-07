<?php
namespace Mouf\Utils\Cache\Service;

use Mouf\InstanceProxy;

use Mouf\Reflection\MoufReflectionProxy;

use Mouf\Html\HtmlElement\HtmlBlock;

use Mouf\MoufManager;

use Mouf\Mvc\Splash\Controllers\Controller;

/**
 * This service can purge the cache of ALL cache instances (implementing CacheInterface) declared in Mouf.
 */
class PurgeCacheService {

	/**
	 * Purges the cache of ALL cache instances declared in Mouf.
	 */
	public static function purgeAll() {

		$moufManager = MoufManager::getMoufManager();
		$instances = $moufManager->findInstances("Mouf\\Utils\\Cache\\CacheInterface");
		
		foreach ($instances as $instanceName) {
			$cacheService = $moufManager->getInstance($instanceName);
			/* @var $cacheService CacheInterface */
		
			$cacheService->purgeAll();
		}
		
	}
		
}

?>