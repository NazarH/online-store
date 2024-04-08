<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $categories = Category::get()->toTree();

        return view('client.catalog.categories.index', ['categories' => $categories]);
    }
}
