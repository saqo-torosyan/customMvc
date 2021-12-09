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

    /**
     * @param $rootPath
     */
    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;

        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    /**
     * @return void
     */
    public function run()
    {
        echo $this->router->resolve();
    }
}