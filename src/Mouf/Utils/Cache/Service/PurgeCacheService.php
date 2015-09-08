<?php
namespace Mouf\Utils\Cache\Service;

use Mouf\InstanceProxy;

use Mouf\Reflection\MoufReflectionProxy;

use Mouf\Html\HtmlElement\HtmlBlock;

use Mouf\MoufManager;

use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\Utils\CompositeException;

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

		$compositeException = new CompositeException();

		foreach ($instances as $instanceName) {
			try {
				$cacheService = $moufManager->getInstance($instanceName);
				/* @var $cacheService CacheInterface */

				$cacheService->purgeAll();
			} catch (\Exception $e) {
				$compositeException->add($e);
			}
		}

		if (!$compositeException->isEmpty()) {
			throw $compositeException;
		}
	}
		
}

?>