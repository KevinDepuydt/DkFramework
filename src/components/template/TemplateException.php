<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 06/02/2016
 * Time: 14:48
 */

namespace Core\Components\Template;

use Core\Components\Logger\Logger;

class TemplateException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
        Logger::errorLog('-- Template error : '.$message);
    }
}