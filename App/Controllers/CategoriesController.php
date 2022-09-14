<?php

namespace App\Controllers;

use App\Models\Category;
use App\Validators\Categories\CreateCategoryValidator;
use Core\Controller;
use Core\View;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all()->get();
        View::render('categories/index', compact('categories')); // ['categories' => $categories]
    }

    public function show(int $id)
    {
        $category = Category::find($id);
        View::render('categories/show', compact('category'));
    }
}
