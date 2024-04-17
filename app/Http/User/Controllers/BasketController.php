<?php

namespace App\Http\User\Controllers;

use App\Actions\User\Basket\OrderCreateAction;
use App\Facades\Basket;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as BasketRequest;
use Illuminate\View\View;

class BasketController extends Controller
{
    /**
     * Відображає сторінку корзини з товарами користувача.
     *
     * @return View
     */
    public function index(): View
    {
        if (Request::hasCookie('key')) {
            $key = Cookie::get('key');
            $order = Order::query()->where('key', '=', $key)->with('products')->first();
            $products = $order->products;
        } else {
            $products = new Collection();
            $order = new Collection();
        }

        return view('client.basket.index', ['products' => $products, 'order' => $order]);
    }

    /**
     * Додає товар до корзини користувача.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(Product $product): RedirectResponse
    {
        if (Request::hasCookie('key')) {
            $key = Cookie::get('key');

            $order = Order::where('key', '=', $key)->first();
        } else {
            $key = Str::random(40);
            Cookie::queue('key', $key, 0);

            $user_id = Auth::user()?->id;

            $order = OrderCreateAction::run($key, $user_id);
        }

        $order->products()->attach($product->id);

        Basket::search($order->id, $product->id)->update(['price' => $product->price]);

        return redirect()->back();
    }

    /**
     * Оновлює кількість товару в корзині користувача.
     *
     * @param BasketRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(BasketRequest $request, Product $product): RedirectResponse
    {
        $key = Cookie::get('key');
        $order =  Order::where('key', '=', $key)->first();

        $orderProduct = OrderProduct::search($order->id, $product->id)->first();
        $orderProduct->update(['count' => $request->count]);
        $orderProduct->update(['price' => $product->price * $orderProduct->count]);

        return redirect()->back();
    }

    /**
     * Видаляє товар з корзини користувача.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $key = Cookie::get('key');

        $order = Order::where('key', '=', $key)->first();

        $order->products()->detach($product->id);

        return redirect()->back();
    }
}
