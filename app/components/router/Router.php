<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 29/11/2015
 * Time: 16:52
 */

namespace App\Components\Router;

use Symfony\Component\Yaml\Yaml;

class Router
{
    public $url;
    public $routes = [];
    public $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
        $this->constructRoutes();
    }

    public function get($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    public function add($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null)
            $name = $callable;
        if ($name)
            $this->namedRoutes[$name] = $route;

        return $route;
    }

    public function check()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
            throw new RouterException('REQUEST_METHOD does not exist');

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url))
                return $route->call();
        }

        $this->get('',"Front#urlError")->call();

        return true;
    }

    public function url($name, $params = [])
    {
        if (!isset($this->namedRoutes[$name]))
            throw new RouterException('No route matches this name');

        return $this->namedRoutes[$name]->getUrl($params);
    }

    public function getRoutes()
    {
        var_dump($this->routes);
    }

    private function constructRoutes()
    {
        $data = Yaml::parse(file_get_contents("config/routes.yml"));

        foreach ($data as $route) {
            if (empty($route['method']))
                $route['method'] = "get";

            if (!$this->isValidMethod($route['method']))
                continue;
            else
                $this->buildRoute(strtolower($route['method']), $route['url'], ucfirst($route['controller']), $route['action']);
        }
    }

    private function isValidMethod($method) {
        return in_array(strtolower($method), ['get', 'post']);
    }

    private function buildRoute($method, $url, $controller, $action) {
        $this->$method($url, $controller."#".$action);
    }
}