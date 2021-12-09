<?php

namespace app\core;

/**
 * Class Request
 *
 * @package app\core
 */
class Request
{
    /**
     * @return false|mixed|string
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return array
     */
    public function getBody()
    {
        $body       = [];
        $method     = $this->getMethod();
        $params     = [];
        $filterType = INPUT_POST;

        switch ($method) {
            case 'get':
                $params = $_GET;
                $filterType = INPUT_GET;
                break;
            case 'post':
                $params = $_POST;
                break;
        }

        foreach ($params as $key => $value) {
            $body[$key] = filter_input($filterType, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }
}