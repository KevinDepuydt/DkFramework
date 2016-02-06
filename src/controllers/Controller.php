<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 21/01/2016
 * Time: 12:02
 */

namespace Core\Controllers;

use Core\Components\Router\Router,
    Core\Components\Template\Template,
    Core\Components\Tools\Tools,
    Symfony\Component\Yaml\Yaml,
    ORM\Connection,
    ORM\Entity\Manager;

abstract class Controller
{
    protected $tpl;
    protected $tplDir = VIEWS_DIR;
    protected $tools;
    protected $em;
    protected $connection;

    private $routesUrl;

    /**
     * @var $routes : contains route_name => url
     */
    protected $routes;

    public function __construct()
    {
        /** twig init */
        $this->tpl = new Template($this->tplDir);

        /** tools init */
        $this->tools = new Tools();

        /** routes name and url init */
        $this->initRoutesNameAndUrl();

        /** template url init */
        $this->initTemplateFunctions();

        /** database connection init */
        $this->initConnection();

        /** entity manager init */
        $this->initEntityManager();
    }

    public function getTemplateObject()
    {
        return $this->tpl;
    }

    public function getToolsObject()
    {
        return $this->tools;
    }

    public static function getRequestUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }

    protected function getDbParams()
    {
        return Yaml::parse(file_get_contents(CONFIG_DIR."database.yml"));
    }

    private function initRoutesNameAndUrl()
    {
        $data = Router::getRoutesData();
        foreach ($data as $name => $value) {
            $this->routesUrl[$name] = BASE_ROUTE_URL.$value['url'];
        }
        // add extra route to get self url
        $this->routesUrl['self'] = $this->getRequestUrl();
    }

    private function initTemplateFunctions()
    {
        // return route name url
        $this->tpl->addFunction('getRoute', function($name) {
            return $this->routesUrl[$name];
        });
    }

    private function initConnection() {
        $data = $this->getDbParams();
        $this->connection = new Connection($data['host'], $data['database'], $data['username'], $data['password']);
    }

    private function initEntityManager() {
        $this->em = new Manager();
    }
}