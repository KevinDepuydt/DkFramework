<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 21/01/2016
 * Time: 12:02
 */

namespace App\Controllers;

use App\Components\Template\Template,
    App\Components\Tools\Tools;

abstract class Controller
{
    protected $tpl;
    protected $tplDir = 'app/views';
    protected $tools;

    public function __construct() {
        /** TWIG INIT */
        $this->tpl = new Template($this->tplDir);
        $this->tools = new Tools();

        $this->tpl->addFunction('getSelfUrl', function() {
            return $this->getRequestUrl();
        });


        $this->tpl->addFunction('selfUrl', $this->getRequestUrl());
    }

    public function getTemplateObject()
    {
        return $this->tpl;
    }

    public function getToolsObject()
    {
        return $this->tools;
    }

    public static function getRequestUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
}