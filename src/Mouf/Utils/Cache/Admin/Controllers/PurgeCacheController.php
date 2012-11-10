<?php
namespace Mouf\Utils\Cache\Admin\Controllers;

use Mouf\InstanceProxy;

use Mouf\Reflection\MoufReflectionProxy;

use Mouf\Html\HtmlElement\HtmlBlock;

use Mouf\MoufManager;

use Mouf\Mvc\Splash\Controllers\Controller;

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
		$url = MoufReflectionProxy::getLocalUrlToProject()."../../../vendor/mouf/utils.cache.cache-interface/src/direct/purge_all.php?selfedit=".urlencode($selfedit);
		
		$response = self::performRequest($url);

		if (!empty($response)) {
			throw new \Exception("Unable to unserialize message:\n".$response."\n<br/>URL in error: <a href='".plainstring_to_htmlprotected($url)."'>".plainstring_to_htmlprotected($url)."</a>");
		}
	}
	
	private static function performRequest($url, $post = array()) {
		// preparation de l'envoi
		$ch = curl_init();
				
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if($post) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		} else
			curl_setopt($ch, CURLOPT_POST, false);
		$response = curl_exec($ch );
		
		if( curl_error($ch) ) { 
			throw new Exception("An error occured: ".curl_error($ch));
		}
		curl_close( $ch );
		
		return $response;
	}
		
}

?>