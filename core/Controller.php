<?php

namespace app\core;

/**
 * Class Controller
 *
 * @package app\core
 */
class Controller
{
    /**
     * @param $view
     * @param $params
     * @return array|false|string|string[]
     */
    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }
}