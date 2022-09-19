<?php

namespace App\Controllers\Admin;

use Core\View;

class PostsController extends BaseController
{
    public function index()
    {
        View::render('admin/posts/index');
    }
}
