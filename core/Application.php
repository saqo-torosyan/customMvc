<?php

namespace app\core;

/**
 * Class Application
 *
 * @package app\core
 */
class Application
{
    public static string $ROOT_DIR;

    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Database $db;

    public static Application $app;

    /**
     * @return Controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param $rootPath
     */
    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database();
    }

    /**
     * @return void
     */
    public function run()
    {
        echo $this->router->resolve();
    }
}