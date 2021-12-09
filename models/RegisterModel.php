<?php

namespace app\models;

use app\core\Model;

/**
 * Class RegisterModel
 *
 * @package app\models
 */
class RegisterModel extends Model
{
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
    public string $confirm_password;

    public function register()
    {
        return true;
    }
}