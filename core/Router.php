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

        if (is_array($callback)) {
            $callback[0] = new $callback[0](0);
        }

        return call_user_func($callback, $this->request);
    }

    /**
     * @param $view
     * @param array $params
     * @return array|false|string|string[]
     */
    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);

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
     * @param array $params
     * @return false|string
     */
    protected function renderOnlyView($view, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

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