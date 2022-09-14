<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Helpers\SessionHelper;

class AuthController extends Controller
{
    public function login()
    {
        View::render('auth/login');
    }

    public function logout()
    {

    }

    public function registration()
    {
        View::render('auth/register');
    }

    public function verify()
    {

    }

    public function before(string $action): bool
    {
        if (in_array($action, ['login', 'registration']) && SessionHelper::authCheck()) {
            return false;
        }

        return parent::before($action);
    }
}
