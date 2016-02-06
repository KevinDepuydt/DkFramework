<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 26/12/2015
 * Time: 11:17
 */

namespace Core\Components\Template;


use Core\Components\Tools\ToolsExceptions;

class Template
{
    private $twig;
    private $twigLoader;
    private $vars;

    public function __construct($templateDir, $cacheDir = false) {

        /** Twig init */
        $this->twigLoader = new \Twig_Loader_Filesystem($templateDir);
        $this->twig = new \Twig_Environment($this->twigLoader, array(
            'cache' => $cacheDir,
        ));

        $this->vars = [
            'site_title' => SITE_TITLE
        ];

        $this->addCssFile(CSS_DIR.'reset.css');
        $this->addCssFile(CSS_DIR.'fonts.css');
        $this->addCssFile(CSS_DIR.'global.css');
        $this->addJsFile(JS_DIR.'global.js');
        $this->addJQuery();

    }

    /** RENDER */

    public function render($template)
    {
        try {
            echo $this->twig->render($template, $this->vars);
        } catch(TemplateException $e) {
            throw new TemplateException($e->getMessage());
        }
    }

    /** ADD VARS */

    public function addVar($key, $value) {
        try {
            $this->vars[$key] = $value;
        } catch(TemplateException $e) {
            throw new TemplateException($e->getMessage());
        }
    }

    public function addArrayVars($array) {
        try {
            $this->vars = array_merge($this->vars, $array);
        } catch(TemplateException $e) {
            throw new TemplateException($e->getMessage());
        }
    }

    /** ADD FUNCTION */

    public function addFunction($name, $callable) {
        try {
            $function = new \Twig_SimpleFunction($name, $callable);
            $this->twig->addFunction($function);
        } catch(TemplateException $e) {
            throw new TemplateException($e->getMessage());
        }
    }

    /** NEED */

    public function addCssFile($pathToCss, $placeFirst = false) {
        try {
            if ($placeFirst && isset($this->vars['assets']['css']))
                array_unshift($this->vars['assets']['css'], $pathToCss);
            else
                $this->vars['assets']['css'][] = $pathToCss;
        } catch(TemplateException $e) {
            throw new TemplateException($e->getMessage());
        }
    }

    public function addJsFile($pathToJs, $placeFirst = false) {
        try {
            if ($placeFirst)
                array_unshift($this->vars['assets']['js'], $pathToJs);
            else
                $this->vars['assets']['js'][] = $pathToJs;
        } catch(TemplateException $e) {
            throw new TemplateException($e->getMessage());
        }
    }

    public function addJQuery() {
        try {
            $this->addJsFile(JS_DIR.'jquery-1.12.0.min.js', true);
        } catch(TemplateException $e) {
            throw new TemplateException($e->getMessage());
        }
    }

    public function addBootstrap()
    {
        try {
            $this->addCssFile(BOOTSTRAP_DIR_CSS.'bootstrap.min.css', true);
            $this->addCssFile(BOOTSTRAP_DIR_CSS.'bootstrap-theme.min.css', true);
            $this->addJsFile(BOOTSTRAP_DIR_JS.'bootstrap.min.js');
        } catch(TemplateException $e) {
            throw new TemplateException($e->getMessage());
        }
    }

    public function addFontAwesome()
    {
        try {
            $this->addCssFile(FONT_AWESOME_CSS_DIR.'font-awesome.min.css');
        } catch(TemplateException $e) {
            throw new TemplateException($e->getMessage());
        }
    }

    public function addSlick()
    {
        try {
            $this->addCssFile(BASE_SITE.'assets/slick/slick.css');
            $this->addCssFile(BASE_SITE.'assets/slick/slick-theme.css');
            $this->addJsFile(BASE_SITE.'assets/slick/slick.min.js');
        } catch(TemplateException $e) {
            throw new TemplateException($e->getMessage());
        }
    }

}