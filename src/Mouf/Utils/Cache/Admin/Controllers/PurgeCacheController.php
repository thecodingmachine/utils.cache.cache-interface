<?php
namespace Mouf\Utils\Cache\Admin\Controllers;

use Mouf\InstanceProxy;

use Mouf\Reflection\MoufReflectionProxy;

use Mouf\Html\HtmlElement\HtmlBlock;

use Mouf\MoufManager;

use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\ClassProxy;

/**
 * The controller to purge all caches.
 *
 * @Component
 */
class PurgeCacheController extends Controller {

	/**
	 * The default template to use for this controller (will be the mouf template)
	 *
	 * @Property
	 * @Compulsory 
	 * @var TemplateInterface
	 */
	public $template;
	
	/**
	 * 
	 * @var HtmlBlock
	 */
	public $content;
	
	protected $selfedit;
	protected $done;
	protected $name;
	
	/**
	 * Admin page used to purge all caches.
	 *
	 * @Action
	 * @Logged
	 */
	public function defaultAction($selfedit = "false", $done = "false") {
		$menu = MoufManager::getMoufManager()->getInstance('utilsCacheInterfacePurgeAllCachesMenuItem');
		$menu->setIsActive(true);
		
		$this->selfedit = $selfedit;
		$this->done = $done;
		$this->content->addFile(dirname(__FILE__)."/../../../../../views/purge.php", $this);
		$this->template->toHtml();
	}
	
	/**
	 * Admin page used to purge a single instance.
	 *
	 * @URL /purgeCacheInstance/
	 * @Logged
	 */
	public function purgeCacheInstance($name, $selfedit = "false") {
		$menu = MoufManager::getMoufManager()->getInstance('utilsCacheInterfacePurgeOneCacheMenuItem');
		$menu->setIsActive(true);
		$this->name = $name;
		$cacheService = new InstanceProxy($name, $selfedit == "true");
		$cacheService->purgeAll();
	
		$this->selfedit = $selfedit;
		$this->content->addFile(dirname(__FILE__)."/../../../../../views/purgeInstanceDone.php", $this);
		$this->template->toHtml();
	}

	/**
	 * Finds all the instances implementing the CacheInterface, and calls the "purge" method on them.
	 * 
	 * @Action
	 * @param string $selfedit
	 */
	public function purge($selfedit = "false") {
		$this->doPurge($selfedit);
		
		header("Location: .?done=true&selfedit=".urlencode($selfedit));
	}
	
	
	
	/**
	 * Finds all the instances implementing the CacheInterface, and calls the "purge" method on them.
	 * 
	 * @Action
	 * @param string $selfedit
	 */
	public function doPurge($selfedit = "false") {
		$purgeCacheService = new ClassProxy("Mouf\\Utils\\Cache\\Service\\PurgeCacheService");
		$purgeCacheService->purgeAll();
	}
		
}

?>