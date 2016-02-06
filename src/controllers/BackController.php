<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 21/01/2016
 * Time: 12:00
 */

namespace Core\Controllers;

use ORM\Console\Command\Generate\Entity;

class BackController extends Controller
{
    public function __construct()
    {
        parent::__construct(); // initialize $this->tpl + $this->tools
    }

    public function createEntityAction()
    {

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

    public function createEntityPostedAction()
    {

        if ($_POST) {

            if (!empty($_POST['entityName']) && !empty($_POST['tableName'])) {

                $data = $this->getDbParams();

                $args = [
                    '',
                    $_POST['tableName'],
                    $_POST['entityName'],
                    $data['host'],
                    $data['database'],
                    $data['username'],
                    $data['password']
                ];

                if (Entity::tableExist($_POST['tableName']) && !Entity::entityExist($_POST['entityName'])) {
                    $generated = new Entity($args);

                    if ($generated) {
                        $this->tpl->addArrayVars([
                            'posted' => [
                                'success' => true,
                                'message' => "L'entité ".ucfirst($_POST['entityName'])." à été créée avec succès!"
                            ]
                        ]);
                    } else {
                        $this->tpl->addArrayVars([
                            'posted' => [
                                'success' => false,
                                'message' => "Erreur lors de la génération de l'entité"
                            ]
                        ]);
                    }
                } else {
                    if (Entity::entityExist(ucfirst($_POST['entityName']))) {
                        $this->tpl->addArrayVars([
                            'posted' => [
                                'success' => false,
                                'message' => "Cette entité à déjà été créée, veuillez supprimer cette entité manuellement afin de la recréer"
                            ]
                        ]);
                    } else {
                        $this->tpl->addArrayVars([
                            'posted' => [
                                'success' => false,
                                'message' => "La table saisie n'existe pas dans la base de donnée"
                            ]
                        ]);
                    }
                }


            } else {
                $this->tpl->addArrayVars([
                    'posted' => [
                        'success' => false,
                        'message' => "L'un des champs est vide"
                    ]
                ]);
            }
        }

        $this->createEntityAction();
    }

}