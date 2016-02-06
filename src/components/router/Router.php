<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 29/11/2015
 * Time: 16:52
 */

namespace Core\Components\Router;

use Symfony\Component\Yaml\Yaml;

class Router
{
    public $url;
    private $routesData = [];
    public $routes = [];
    public $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
        $this->routesData = self::getRoutesData();
        $this->constructRoutes();
    }

    public function get($path, $callable, $name = null)
    {
        try {
            return $this->add($path, $callable, $name, 'GET');
        } catch (RouterException $e) {
            throw new RouterException($e->getMessage());
        }
    }

    public function post($path, $callable, $name = null)
    {
        try {
            return $this->add($path, $callable, $name, 'POST');
        } catch (RouterException $e) {
            throw new RouterException($e->getMessage());
        }
    }

    public function add($path, $callable, $name, $method)
    {
        try {
            $route = new Route($path, $callable);
            $this->routes[$method][] = $route;
            if (is_string($callable) && $name === null)
                $name = $callable;
            if ($name)
                $this->namedRoutes[$name] = $route;

            return $route;
        } catch (RouterException $e) {
            throw new RouterException($e->getMessage());
        }
    }

    public function check()
    {
        try {
            if (!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
                throw new RouterException('REQUEST_METHOD does not exist');

            foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
                if ($route->match($this->url))
                    return $route->call();
            }

            $this->get('',"Front#urlError")->call();

            return true;
        } catch (RouterException $e) {
            throw new RouterException($e->getMessage());
        }
    }

    public function url($name, $params = [])
    {
        try {
            if (!isset($this->namedRoutes[$name]))
                throw new RouterException('No route matches this name');

            return $this->namedRoutes[$name]->getUrl($params);
        } catch (RouterException $e) {
            throw new RouterException($e->getMessage());
        }
    }

    public function getRoutes()
    {
        var_dump($this->routes);
    }

    private function constructRoutes()
    {
        try {
            if (empty($this->routesData))
                $this->routesData = self::getRoutesData();

            foreach ($this->routesData as $route) {
                if (empty($route['method']))
                    $route['method'] = "get";

                if (!$this->isValidMethod($route['method']))
                    continue;
                else
                    $this->buildRoute(strtolower($route['method']), $route['url'], ucfirst($route['controller']), $route['action']);
            }
        } catch (RouterException $e) {
            throw new RouterException($e->getMessage());
        }
    }

    private function isValidMethod($method) {
        try {
            return in_array(strtolower($method), ['get', 'post']);
        } catch (RouterException $e) {
            throw new RouterException($e->getMessage());
        }
    }

    private function buildRoute($method, $url, $controller, $action) {
        try {
            $this->$method($url, $controller."#".$action);
        } catch (RouterException $e) {
            throw new RouterException($e->getMessage());
        }
    }

    public static function getRoutesData() {
        try {
            return Yaml::parse(file_get_contents(CONFIG_DIR."routes.yml"));
        } catch (RouterException $e) {
            throw new RouterException($e->getMessage());
        }
    }
}