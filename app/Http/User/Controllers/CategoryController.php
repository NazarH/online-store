<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $category = Category::where('slug', '=', $request->slug)->first();
        $products = $category->products()->paginate(9);

        return view('client.catalog.category.index', ['category' => $category, 'products' => $products]);
    }
}
