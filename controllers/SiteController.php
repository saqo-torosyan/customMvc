<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

/**
 * Class SiteController
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @return array|false|string|string[]
     */
    public function home()
    {
        $params = [
            'name' => 'Sargis'
        ];

        return $this->render('home', $params);
    }

    /**
     * @return array|false|string|string[]
     */
    public function contact()
    {
        return $this->render('contact');
    }

    /**
     * @return string
     */
    public function handleContact(Request $request)
    {
        $body = $request->getBody();
        var_dump($body);
        return "function handleContact";
    }
}