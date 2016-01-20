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

/** SETTINGS */
define('ROOT', '/dkframework/');
define('CSS_DIR', ROOT.'public/css/');
define('JS_DIR', ROOT.'public/js/');
define('BASE_SITE', ROOT);
define('VENDOR_DIR', ROOT.'vendor/');

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
