<?php

use Mouf\Html\HtmlElement\HtmlFromFile;
use Mouf\MoufManager;
use Mouf\MoufUtils;

// Because cache-interface can be used in both the application and in Mouf admin, there are 2
// PurgeCacheController classes. We must be sure to load the right one.
// So instead of relying on the autoloader that will favor the class in Mouf admin, we force the
// loading of the class.
require_once 'src/Mouf/Utils/Cache/Admin/Controllers/PurgeCacheController.php';

MoufUtils::registerMainMenu('utilsMainMenu', 'Utils', null, 'mainMenu', 200);
MoufUtils::registerMenuItem('utilsCacheInterfaceMenu', 'Cache management', null, 'utilsMainMenu', 50);
MoufUtils::registerMenuItem('utilsCacheInterfacePurgeAllCachesMenuItem', 'Purge all caches', 'purgeCaches/', 'utilsCacheInterfaceMenu', 10);
MoufUtils::registerChooseInstanceMenuItem('utilsCacheInterfacePurgeOneCacheMenuItem', 'Purge a cache instance', 'purgeCacheInstance/', 'Mouf\\Utils\\Cache\\CacheInterface', 'utilsCacheInterfaceMenu', 10);

$moufManager = MoufManager::getMoufManager();
$navbar = $moufManager->getInstance("navBar");
/*$htmlString = new HtmlString();
$htmlString->htmlString = '<form class="navbar-form pull-right" style="margin-right: 5px">
    <button class="btn btn-danger">Purge cache</button>
    </form>';*/
$navbar->children[] = new HtmlFromFile("../../../vendor/mouf/utils.cache.cache-interface/src/views/purgebutton.php");

// Controller declaration
$moufManager->declareComponent('purgeCaches', 'Mouf\\Utils\\Cache\\Admin\\Controllers\\PurgeCacheController', true);
$moufManager->bindComponents('purgeCaches', 'template', 'moufTemplate');
$moufManager->bindComponents('purgeCaches', 'content', 'block.content');


unset($moufManager);
