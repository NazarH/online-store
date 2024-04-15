<?php

namespace App\Http\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HomeController extends Controller
{
    /**
     * Обробник для відображення головної сторінки адміністратора.
     *
     * @return View
     */
    public function __invoke(): View
    {
        $this->makeCache();

        $orders = Order::latest()->take(20)->get();

        return view('admin.home', ['orders' => $orders]);
    }

    /**
     * Метод для завантаження Excel-файлу з даними.
     */
    private function makeCache()
    {
        Cache::remember('statistic', 300, function(){
            return [
                'orders' => Order::count(),
                'products' => Product::count(),
                'users' => User::count(),
                'leads' => Lead::count()
            ];
        });
    }
}
