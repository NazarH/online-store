<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StaticPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Показує головну сторінку з першими чотирма продуктами.
     *
     * @return View
     */
    public function index(): View
    {
        $products = Product::query()->take(4)
            ->with('category', 'properties')
            ->get();

        return view('client.main.index', ['products' => $products]);
    }

    /**
     * Тестовий метод, який перенаправляє на іншу сторінку і видаляє певний cookie.
     *
     * @return RedirectResponse
     */
    public function test(): RedirectResponse
    {
        $products = Product::query()->take(4)
            ->with('category', 'properties')
            ->get();

        return redirect()->route('client.articles.index')->withCookie(Cookie::forget('key'));
    }
}
