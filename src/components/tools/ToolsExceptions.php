<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 06/02/2016
 * Time: 14:49
 */

namespace Core\Components\Tools;

use Core\Components\Logger\Logger;

class ToolsExceptions extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
        Logger::errorLog('-- Tools error : '.$message);
    }
}