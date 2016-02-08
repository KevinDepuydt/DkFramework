<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 21/01/2016
 * Time: 12:00
 */

namespace Core\Controllers;

use Core\Components\Generator\ModuleGenerator;
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
        $this->tpl->addCssFile(CSS_DIR.'entity-module-create.css');

        $this->tpl->addArrayVars([
            'page_title' => "Créateur d'Entité",
            'text' => "Créer ton entité en remplissant le formulaire suivant"
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
        } else {
            throw new ControllerException('Impossible to retrieve data send by form');
        }

        $this->createEntityAction();
    }

    public function createModuleAction() {
        $this->tpl->addBootstrap();
        $this->tpl->addFontAwesome();
        $this->tpl->addJQuery();
        $this->tpl->addCssFile(CSS_DIR.'entity-module-create.css');

        $this->tpl->addArrayVars([
            'page_title' => "Créateur de module",
            'text' => "Créer la base de ton module en renseignant son nom"
        ]);

        $this->tpl->render('module-create.html.twig');
    }

    public function createModulePostedAction() {

        if ($_POST) {

            if (!empty($_POST['moduleName'])) {

                $mg = new ModuleGenerator($_POST['moduleName']);

                if ($mg->isValidName()) {
                    if (!$mg->exist()) {

                        $mg->generate();

                        if ($mg->exist()) {
                            $this->tpl->addArrayVars([
                                'posted' => [
                                    'success' => true,
                                    'message' => "Le module a bien été créé"
                                ]
                            ]);
                        } else {
                            $this->tpl->addArrayVars([
                                'posted' => [
                                    'success' => false,
                                    'message' => "Une erreur est survenue lors de la création du module"
                                ]
                            ]);
                        }
                    } else {
                        $this->tpl->addArrayVars([
                            'posted' => [
                                'success' => false,
                                'message' => "Un module de ce nom existe déjà"
                            ]
                        ]);
                    }
                } else {
                    $this->tpl->addArrayVars([
                        'posted' => [
                            'success' => false,
                            'message' => "Le nom du module ne doit contenir que des lettres non accentuées"
                        ]
                    ]);
                }
            } else {
                $this->tpl->addArrayVars([
                    'posted' => [
                        'success' => false,
                        'message' => "Veuillez saisir le nom du module"
                    ]
                ]);
            }
        } else {
            throw new ControllerException('Impossible to retrieve data send by form');
        }

        $this->createModuleAction();
    }
}