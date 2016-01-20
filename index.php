<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 13/01/2016
 * Time: 10:44
 */

require_once 'config/config.php';
require_once 'vendor/autoload.php';

use App\Components\Router\Router;

/** ROUTER */
$router = new Router($_GET['url']);

/** SITE */
$router->get('/', "Front#index");

/** ROUTER EXECUTION */
$router->check();