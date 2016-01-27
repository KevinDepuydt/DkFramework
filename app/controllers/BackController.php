<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 21/01/2016
 * Time: 12:00
 */

namespace App\Controllers;

class BackController extends Controller
{
    public function __construct() {
        // initialize $this->tpl + $this->tools
        parent::__construct();
    }

    public function createEntityAction() {

        $this->tpl->addBootstrap();
        $this->tpl->addFontAwesome();
        $this->tpl->addJQuery();
        //$this->tpl->addJsFile(JS_DIR.'entity-create.js');
        $this->tpl->addCssFile(CSS_DIR.'entity-create.css');

        $this->tpl->addArrayVars([
            'page_title' => "Créateur d'Entité",
            'text' => "Créer ton entité en remplissant le formulaire suivant",
            'self' => parent::getRequestUrl()
        ]);

        $this->tpl->render('entity-create.html.twig');
    }

}