<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 13/01/2016
 * Time: 11:27
 */

namespace Core\Controllers;

use Core\Models\User;

class FrontController extends Controller
{
    public function __construct() {
        // initialize $this->tpl + $this->tools
        parent::__construct();
    }

    /** INDEX */
    public function indexAction()
    {
        $this->tpl->addBootstrap();
        $this->tpl->addFontAwesome();

        $this->tpl->addArrayVars([
            'page_title' => "Index page",
            'text' => "Bienvenue sur la page d'accueil de mon framework"
        ]);

        $this->tpl->render('index.html.twig');
    }

    /** INDEX */
    public function testAction()
    {
        $this->tpl->addBootstrap();
        $this->tpl->addFontAwesome();

        $this->tpl->addArrayVars([
            'page_title' => "Test page",
            'text' => "Page de test du framework"
        ]);
        $this->tpl->render('index.html.twig');
    }

    /** 404 */
    public function urlErrorAction()
    {
        $this->tpl->addFontAwesome();
        $this->tpl->addArrayVars([
            'error_type' => "404",
            'message' => "Cette page n'existe pas!"
        ]);
        $this->tpl->render('404.html.twig');
    }
}