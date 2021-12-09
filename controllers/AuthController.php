<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

/**
 * Class AuthController
 *
 * @package app\controllers
 */
class AuthController extends Controller
{
    /**
     * @return array|false|string|string[]
     */
    public function login(Request $request)
    {
        return $this->render('login');
    }

    /**
     * @return array|false|string|string[]
     */
    public function register(Request $request)
    {
        if ($request->isPost()) {
            return "Handel submitted data";
        }

        return $this->render('register');
    }
}