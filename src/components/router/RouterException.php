<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 29/11/2015
 * Time: 17:02
 */

namespace Core\Components\Router;

use Core\Components\Logger\Logger;

class RouterException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
        Logger::errorLog('-- Router error : '.$message);
    }
}