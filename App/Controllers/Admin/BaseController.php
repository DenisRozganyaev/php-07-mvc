<?php

namespace App\Controllers\Admin;

use App\Helpers\SessionHelper;

class BaseController extends \Core\Controller
{
    public function before(string $action): bool
    {
        return SessionHelper::isAdmin();
    }
}