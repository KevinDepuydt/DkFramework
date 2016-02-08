<?php
/**
 * Created by PhpStorm.
 * User: KevinSup
 * Date: 07/02/2016
 * Time: 15:44
 */

namespace Core\Components\Generator;

class ModuleGenerator
{
    private $name;

    public function __construct($name)
    {
        $this->setName($name);
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function generate()
    {
        $this->generateDirectories();
        $this->generateDefaultController();
        $this->generateIndexTemplate();
    }

    public function isValidName()
    {
        return preg_match("#^[a-z]+$#", $this->getName());
    }

    public function exist()
    {
        return is_dir(MODULES_DIR.$this->getName());
    }

    public function generateDirectories()
    {
        if (!file_exists(MODULES_DIR) && !mkdir(MODULES_DIR))
            throw new ModuleGeneratorException('Error creating the modules container folder');

        if (!mkdir(MODULES_DIR.$this->getName()))
            throw new ModuleGeneratorException('Error creating the module folder');

        if (!mkdir(MODULES_DIR.$this->getName()."/controllers") || !mkdir(MODULES_DIR.$this->getName()."/views"))
            throw new ModuleGeneratorException('Error creating module subfolder');
    }

    public function generateDefaultController()
    {
        $code = "<?php\n\n";
        $code .= "namespace Modules\\".ucfirst($this->getName())."\\Controllers;\n\n";
        $code .= "use Core\\Controllers\\ModuleController;\n\n";

        $code .= "class DefaultController extends ModuleController \n{\n";

        $code .= "\tprivate ".'$moduleName'." = '".$this->getName()."';\n\n";

        $code .= "\tpublic function __construct()\n\t{\n";
        $code .= "\t\t".'parent::__construct($this->moduleName);';
        $code .= "\n\t}\n\n";

        $code .= "\tpublic function indexAction()\n\t{\n";
        $code .= "\t\t".'$this->tpl->addArrayVars(['."\n";
        $code .= "\t\t\t".'\'page_title\' => ucfirst($this->moduleName)." module index page",'."\n";
        $code .= "\t\t\t".'\'text\' => "Bienvenue sur la page d\'accueil du module ".$this->moduleName'."\n";
        $code .= "\t\t".']);';
        $code .= "\n\n";
        $code .= "\t\t".'$this->tpl->render(\'@'.$this->getName().'/index.html.twig\'); // don\'t forget modules template prefix @$this->moduleName';
        $code .= "\n\t}\n\n";
        $code .= "}";

        try {
            file_put_contents(MODULES_DIR.$this->getName()."/controllers/DefaultController.php", $code);
        } catch (ModuleGeneratorException $e) {
            throw new ModuleGeneratorException($e->getMessage());
        }
    }

    public function generateIndexTemplate()
    {
        $code = '<!DOCTYPE html>'."\n";
        $code .= '<html lang="en">'."\n";
        $code .= "\t".'<head>'."\n";
        $code .= "\t\t".'<meta charset="UTF-8">'."\n";
        $code .= "\t\t".'{% for css_url in assets.css %}'."\n";
        $code .= "\t\t\t".'<link rel="stylesheet" type="text/css" href="{{ css_url }}">'."\n";
        $code .= "\t\t".'{% endfor %}'."\n";
        $code .= "\t\t".'{% for js_url in assets.js %}'."\n";
        $code .= "\t\t\t".'<script type="text/javascript" src="{{ js_url }}"></script>'."\n";
        $code .= "\t\t".'{% endfor %}'."\n";
        $code .= "\t\t".'<title>{{ site_title }}</title>'."\n";
        $code .= "\t".'</head>'."\n";
        $code .= "\t".'<body>'."\n";
        $code .= "\t\t".'<h1 class="font-bold darkColor">{{ page_title }}</h1>'."\n";
        $code .= "\t\t".'<p class="font-lightItalic lightColor">{{ text }}</p>'."\n";
        $code .= "\t\t".'<i class="fa fa-star"></i>'."\n\n";
        $code .= "\t\t".'<div class="framework-actions">'."\n";
        $code .= "\t\t\t".'<a href="{{ getRoute("entity_create_get") }}" role="button" class="btn btn-primary btn-lg">Créer une entité</a>'."\n";
        $code .= "\t\t".'</div>'."\n";
        $code .= "\t".'</body>'."\n";
        $code .= '</html>';

        try {
            file_put_contents(MODULES_DIR.$this->getName()."/views/index.html.twig", $code);
        } catch (ModuleGeneratorException $e) {
            throw new ModuleGeneratorException($e->getMessage());
        }
    }
}