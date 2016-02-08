<?php
/**
 * Created by PhpStorm.
 * User: KevinSup
 * Date: 07/02/2016
 * Time: 15:45
 */

namespace Core\Components\Generator;

use Core\Components\Logger\Logger;

class ModuleGeneratorException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
        Logger::errorLog('-- ModuleGenerator error : '.$message);
    }
}