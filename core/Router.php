<?php

namespace app\core;

/**
 * Class Router
 *
 * @package app\core
 */
class Router
{
    public Request $request;
    public Response $response;

    protected array $routes;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @return array|false|mixed|string|string[]
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderContent("404 not found");
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        return call_user_func($callback);
    }

    /**
     * @param $view
     * @return array|false|string|string[]
     */
    public function renderView($view)
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * @return false|string
     */
    protected function layoutContent()
    {
        ob_start();

        require_once Application::$ROOT_DIR . "/views/layouts/main.php";

        return ob_get_clean();
    }

    /**
     * @param $view
     * @return false|string
     */
    protected function renderOnlyView($view)
    {
        ob_start();

        require_once Application::$ROOT_DIR . "/views/$view.php";

        return ob_get_clean();
    }

    /**
     * @param $viewContent
     * @return false|string
     */
    protected function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}