<?php

/**
 * This is the global runtime configuration for Yves and Generated_Yves_Zed in a development environment.
 */

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Acl\AclConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\Log\Config\DefaultLoggerConfig;
use Spryker\Shared\Payone\PayoneConstants;

$config[ApplicationConstants::YVES_SESSION_SAVE_HANDLER] = SessionConstants::SESSION_HANDLER_REDIS;
$config[ApplicationConstants::ZED_SESSION_SAVE_HANDLER] = SessionConstants::SESSION_HANDLER_FILE;

$config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_PROTOCOL] = 'tcp';
$config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_HOST] = '127.0.0.1';
$config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_PORT] = '10009';

$config[ApplicationConstants::ZED_STORAGE_SESSION_REDIS_PROTOCOL] = $config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_PROTOCOL];
$config[ApplicationConstants::ZED_STORAGE_SESSION_REDIS_HOST] = $config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_HOST];
$config[ApplicationConstants::ZED_STORAGE_SESSION_REDIS_PORT] = $config[ApplicationConstants::YVES_STORAGE_SESSION_REDIS_PORT];

$config[ApplicationConstants::YVES_SESSION_COOKIE_DOMAIN] = $config[ApplicationConstants::HOST_YVES];

$config[ApplicationConstants::JENKINS_BASE_URL] = 'http://' . $config[ApplicationConstants::HOST_ZED_GUI] . ':10007/jenkins';
$config[ApplicationConstants::JENKINS_DIRECTORY] = '/data/shop/development/shared/data/common/jenkins';
$config[ApplicationConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED] = true;

$config[PayoneConstants::PAYONE] = [
    PayoneConstants::PAYONE_CREDENTIALS_ENCODING => 'UTF-8',
    PayoneConstants::PAYONE_CREDENTIALS_KEY => 'oZZfMY6L224Q51jq',
    PayoneConstants::PAYONE_CREDENTIALS_MID => '29250',
    PayoneConstants::PAYONE_CREDENTIALS_AID => '29499',
    PayoneConstants::PAYONE_CREDENTIALS_PORTAL_ID => '2020679',
    PayoneConstants::PAYONE_PAYMENT_GATEWAY_URL => 'https://api.pay1.de/post-gateway/',
    PayoneConstants::PAYONE_REDIRECT_SUCCESS_URL => $config[ApplicationConstants::HOST_YVES] . '/checkout/success/',
    PayoneConstants::PAYONE_REDIRECT_ERROR_URL => $config[ApplicationConstants::HOST_YVES] . '/checkout/index/',
    PayoneConstants::PAYONE_REDIRECT_BACK_URL => $config[ApplicationConstants::HOST_YVES] . '/checkout/regular-redirect-payment-cancellation/',
    PayoneConstants::PAYONE_MODE => '',
];

$config[ApplicationConstants::NAVIGATION_CACHE_ENABLED] = true;

$config[AclConstants::ACL_USER_RULE_WHITELIST][] = [
    'bundle' => 'wdt',
    'controller' => '*',
    'action' => '*',
    'type' => 'allow',
];

$config[ApplicationConstants::PROPEL_DEBUG] = true;
$config[ApplicationConstants::PROPEL_SHOW_EXTENDED_EXCEPTION] = true;

$config[ApplicationConstants::ALLOW_INTEGRATION_CHECKS] = true;
$config[ApplicationConstants::DISPLAY_ERRORS] = true;
$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG] = true;
$config[ApplicationConstants::SET_REPEAT_DATA] = true;
$config[ApplicationConstants::STORE_PREFIX] = 'DEV';

$config[ApplicationConstants::ENABLE_WEB_PROFILER] = true;
$config[ApplicationConstants::SHOW_SYMFONY_TOOLBAR] = true;

$config[DefaultLoggerConfig::DEFAULT_LOG_LEVEL] = Monolog\Logger::INFO;
