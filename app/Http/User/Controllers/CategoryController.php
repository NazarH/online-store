<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Відображає сторінку категорії товарів у каталозі.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $category = Category::where('slug', '=', $request->slug)->first();

        if ($request->all()) {
            $products = Product::filter()->paginate(9);
        } else {
            $products = $category->products()->paginate(9);
        }

        return view('client.catalog.category.index', ['category' => $category, 'products' => $products]);
    }
}
