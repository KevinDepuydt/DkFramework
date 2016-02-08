<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 13/01/2016
 * Time: 10:37
 * Description : contains constant used for configuration of framework
 */

/** MODE */
define('DEVELOPMENT_ENVIRONMENT', true);

/** SITE PROPERTIES */
define('SITE_TITLE', 'DkFramework');
define('PROJECT_DIR_NAME', 'dkframework');

/** SETTINGS */
define('ROOT', '/'.PROJECT_DIR_NAME.'/');
define('BASE_SITE', ROOT);
define('BASE_ROUTE_URL', '/'.PROJECT_DIR_NAME);
define('DEV_MODE', false);

/** DIRECTORIES */
define('CSS_DIR', ROOT.'public/css/');
define('JS_DIR', ROOT.'public/js/');
define('ENTITY_DIR', "src/models/");
define('CONFIG_DIR', "app/config/");
define('VIEWS_DIR', "src/views/");
define('LOGS_DIR', "app/logs/");
define('VENDOR_DIR', ROOT.'vendor/');
define('MODULES_DIR', "modules/");

/** BOOTSTRAP */
define('BOOTSTRAP_DIR', VENDOR_DIR.'twbs/bootstrap/dist/');
define('BOOTSTRAP_DIR_CSS', BOOTSTRAP_DIR.'css/');
define('BOOTSTRAP_DIR_JS', BOOTSTRAP_DIR.'js/');

/** FONT-AWESOME */
define('FONT_AWESOME_DIR', VENDOR_DIR.'fortawesome/font-awesome/');
define('FONT_AWESOME_CSS_DIR', FONT_AWESOME_DIR.'css/');

/** DATABASE */
define('DB_NAME', 'test');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

/** LOGS */
define('LOGS_ACTIVE', true);
define('ACCESS_LOG_FILE', LOGS_DIR."access.txt");
define('ERROR_LOG_FILE', LOGS_DIR."error.txt");
