<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Validators\AuthValidator;
use Core\Controller;
use Core\View;
use App\Helpers\SessionHelper;

class AuthController extends Controller
{
    protected array $fields = [];

    public function login()
    {
        View::render('auth/login');
    }

    public function logout()
    {
        SessionHelper::destroy();
        redirect();
    }

    public function registration()
    {
        View::render('auth/register');
    }

    public function verify()
    {
        unset($_SESSION['auth']['login']);

        if (!AuthService::call($this->fields)) {
            $_SESSION['auth']['login'] = array_merge($_SESSION['auth']['login'], $this->fields);
            redirect('login');
        }

        redirect();
    }

    public function before(string $action): bool
    {
        if (in_array($action, ['login', 'registration']) && SessionHelper::authCheck()) {
            return false;
        }

        if (in_array($action, ['verify'])) {
            $this->fields = filter_input_array(INPUT_POST, $_POST, true);
        }

        return parent::before($action);
    }
}
