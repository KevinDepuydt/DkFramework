<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 13/01/2016
 * Time: 10:44
 */

require_once 'app/config/config.php';
require_once 'vendor/autoload.php';

use Core\Components\Router\Router;

/** ROUTER */
$router = new Router($_GET['url']);

/** ROUTER EXECUTION */
$router->check();
