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

    public function get($path, $callable, $module = null, $with = null, $name = null)
    {
        return $this->add($path, $callable, $name, 'GET', $module, $with);
    }

    public function post($path, $callable, $module = null, $with = null, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST', $module, $with);
    }

    public function add($path, $callable, $name, $method, $module = null, $with = null)
    {
        $route = new Route($path, $callable, $module);
        $this->addWithParams($route, $with);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null)
            $name = $callable;
        if ($name)
            $this->namedRoutes[$name] = $route;

        if (!$route)
            throw new RouterException('Error creating route '.$path);

        return $route;
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
        if (empty($this->routesData))
            $this->routesData = self::getRoutesData();

        foreach ($this->routesData as $route) {
            if (empty($route['method']))
                $route['method'] = "get";

            if (!$this->isValidMethod($route['method']))
                throw new RouterException('Invalid method for route '.$route['url']." (".$route['method'].")");
            else
                $this->buildRoute(strtolower($route['method']), $route['url'], ucfirst($route['controller']), $route['action'], (isset($route['module']) ? $route['module'] : null), (isset($route['with']) ? $route['with'] : null));
        }
    }

    private function isValidMethod($method) {
        return in_array(strtolower($method), ['get', 'post']);
    }

    private function buildRoute($method, $url, $controller, $action, $module = null, $with = null) {
        if (!$this->$method($url, $controller."#".$action, $module, $with))
            throw new RouterException("Impossible de créer la route ".$method."(".$url.", ".$controller."#".$action.")");
    }

    public static function getRoutesData() {

        $appRoutes = Yaml::parse(file_get_contents(CONFIG_DIR."core-routes.yml"));
        $routes = Yaml::parse(file_get_contents(CONFIG_DIR."routes.yml"));

        if (!$appRoutes)
            throw new RouterException('Impossible de récupérer les fichiers de route');

        return array_merge($appRoutes,$routes);
    }

    private function addWithParams($route, $with) {
        if ($with != null and is_array($with)) {
            foreach ($with as $param => $type) {
                switch ($type) {
                    case "int":
                        $route->with($param, '[0-9]+');
                        break;
                    case "string":
                        $route->with($param, '[a-z\-0-9]+');
                        break;
                    default:
                        throw new RouterException('Unknown param type');
                }
            }
        }
    }
}