<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 26/12/2015
 * Time: 11:17
 */

namespace App\Components\Template;


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
        echo $this->twig->render($template, $this->vars);
        return true;
    }

    /** ADD VARS */

    public function addVar($key, $value) {
        $this->vars[$key] = $value;
    }

    public function addArrayVars($array) {
        $this->vars = array_merge($this->vars, $array);
    }

    /** ADD FUNCTION */

    public function addFunction($name, $callable) {

        $function = new \Twig_SimpleFunction($name, $callable);
        $this->twig->addFunction($function);
    }

    /** NEED */

    public function addCssFile($pathToCss, $placeFirst = false) {

        if ($placeFirst && isset($this->vars['assets']['css']))
            array_unshift($this->vars['assets']['css'], $pathToCss);
        else
            $this->vars['assets']['css'][] = $pathToCss;
    }

    public function addJsFile($pathToJs, $placeFirst = false) {
        if ($placeFirst)
            array_unshift($this->vars['assets']['js'], $pathToJs);
        else
            $this->vars['assets']['js'][] = $pathToJs;
    }

    public function addJQuery() {
        $this->addJsFile(JS_DIR.'jquery-1.12.0.min.js', true);
    }

    public function addBootstrap()
    {
        $this->addCssFile(BOOTSTRAP_DIR_CSS.'bootstrap.min.css', true);
        $this->addCssFile(BOOTSTRAP_DIR_CSS.'bootstrap-theme.min.css', true);
        $this->addJsFile(BOOTSTRAP_DIR_JS.'bootstrap.min.js');
    }

    public function addFontAwesome()
    {
        $this->addCssFile(FONT_AWESOME_CSS_DIR.'font-awesome.min.css');
    }

    public function addSlick()
    {
        $this->addCssFile(BASE_SITE.'assets/slick/slick.css');
        $this->addCssFile(BASE_SITE.'assets/slick/slick-theme.css');
        $this->addJsFile(BASE_SITE.'assets/slick/slick.min.js');
    }

}