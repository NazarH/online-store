<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StaticPage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $products = Product::query()->take(4)
            ->with('category', 'properties')
            ->get();

        return view('client.main.index', ['products' => $products]);
    }
}
