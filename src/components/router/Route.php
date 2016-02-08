<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 29/11/2015
 * Time: 16:53
 */

namespace Core\Components\Router;

use Core\Components\Logger\Logger;

class Route
{
    public $path;
    public $callable;
    public $module;
    public $matches = [];
    public $params = [];

    public function __construct($path, $callable, $module)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
        $this->setModule($module);
    }

    public function with($param, $regex) {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('/:([\w]+)/', [$this, 'paramMatch'], $this->path);
        $path = str_replace('/','\/',$path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches))
        {
            return false;
        }

        array_shift($matches);

        $this->matches = $matches;

        return true;
    }

    public function paramMatch($match)
    {
        if (isset($this->params[$match[1]]))
            return '(' . $this->params[$match[1]] . ')';

        return '([^/]+)';
    }

    public function call()
    {
        Logger::accessLog($_SERVER);
        if (is_string($this->callable))
        {
            $params = explode('#', $this->callable);
            $controller = $this->getNamespace() . $params[0] . "Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]."Action"], $this->matches);
        } else
            return call_user_func_array($this->callable, $this->matches);
    }

    public function getUrl($params)
    {
        $path = $this->path;

        foreach($params as $k => $v)
        {
            $path = str_replace(":$k", $v, $path);
        }

        return $path;
    }

    public function setModule($name) {
        $this->module = $name;
    }

    public function getModule() {
        return $this->module;
    }

    public function getNamespace() {
        if ($this->getModule()) {
            return  "Modules\\".ucfirst($this->getModule())."\\Controllers\\";
        } else
            return "Core\\Controllers\\";
    }
}