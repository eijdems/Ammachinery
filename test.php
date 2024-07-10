<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Magento\Framework\App\Bootstrap;
require __DIR__ . '/app/bootstrap.php';
$bootstrap = Bootstrap::create(BP, $_SERVER);

echo "test"; exit();
$objectManager = $bootstrap->getObjectManager();

$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
$connection = $resource->getConnection();

$qry = "SELECT * FROM `setup_module` WHERE `module` = 'MageBeans_Pageimage'";

$cust1 = $connection->fetchAll($qry);

print_r($cust1);
exit;