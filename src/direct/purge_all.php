<?php
use Mouf\MoufManager;

// This file purges all the caches of any instance implementing the CacheInterface interface.

// Disable output buffering
while (ob_get_level() != 0) {
	ob_end_clean();
}

ini_set('display_errors', 1);
// Add E_ERROR to error reporting if it is not already set
error_reporting(E_ERROR | error_reporting());

if (!isset($_REQUEST["selfedit"]) || $_REQUEST["selfedit"]!="true") {
	require_once '../../../../../mouf/Mouf.php';
	$mouf_base_path = ROOT_PATH;
	$selfEdit = false;
} else {
	require_once '../../mouf/Mouf.php';
	$mouf_base_path = ROOT_PATH."mouf/";
	$selfEdit = true;
}

// Note: checking rights is done after loading the required files because we need to open the session
// and only after can we check if it was not loaded before loading it ourselves...
require_once '../../../../../vendor/mouf/mouf/src/direct/utils/check_rights.php';

$moufManager = MoufManager::getMoufManager();
$instances = $moufManager->findInstances("Mouf\\Utils\\Cache\\CacheInterface");

foreach ($instances as $instanceName) {
	$cacheService = $moufManager->getInstance($instanceName);
	/* @var $cacheService CacheInterface */
	
	$cacheService->purgeAll();
}

echo serialize(null);
exit;

?>