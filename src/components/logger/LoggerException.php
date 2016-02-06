<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 06/02/2016
 * Time: 14:48
 */

namespace Core\Components\Logger;

class LoggerException extends \Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
        Logger::errorLog('-- Logger error : '.$message.'. Code '.$code);
    }
}