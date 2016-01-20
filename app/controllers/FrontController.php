<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 13/01/2016
 * Time: 11:27
 */

namespace App\Controllers;

use App\Components\Template\Template,
    App\Components\Tools\Tools;


class FrontController
{
    private $tpl;
    private $tplDir = 'app/views';
    private $tools;

    public function __construct() {
        /** TWIG INIT */
        $this->tpl = new Template($this->tplDir);
        $this->tools = new Tools();
    }

    /** INDEX */
    public function indexAction()
    {
        $this->tpl->addBootstrap();
        $this->tpl->addFontAwesome();

        $this->tpl->addArrayVars([
            'page_title' => "Index-Page",
            'text' => "Bienvenue sur la page d'accueil de mon framework"
        ]);
        $this->tpl->render('index.html.twig');
    }

    /** 404 */
    public function urlErrorAction()
    {
        $this->tpl->addArrayVars([
            'page_title' => "IndexPage",
            'error' => "Cette page n'existe pas!"
        ]);
        $this->tpl->render('404.html.twig');
    }
}