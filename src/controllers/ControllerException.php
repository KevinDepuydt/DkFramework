<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 06/02/2016
 * Time: 14:49
 */

namespace Core\Controllers;


class ControllerException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
        Logger::errorLog('-- Controller error : '.$message);
    }
}