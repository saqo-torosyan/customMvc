<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

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
        $this->setLayout('auth');
        return $this->render('login');
    }

    /**
     * @return array|false|string|string[]
     */
    public function register(Request $request)
    {
        $registerModel = new RegisterModel();

        if ($request->isPost()) {
            $registerModel->loadData($request->body());

            if ($registerModel->validate() && $registerModel->register()) {
                return "Success";
            }

            return $this->render('register', [
                'model' => $registerModel
            ]);
        }

        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $registerModel
        ]);
    }
}