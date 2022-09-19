<?php

namespace App\Controllers\Admin;

use Core\View;

class DashboardController extends BaseController
{
    public function index()
    {
        View::render('admin/dashboard');
    }
}
