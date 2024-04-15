<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class BasketService
{
    /**
     * Пошук запису в таблиці order_products за заданими ідентифікаторами замовлення та продукту.
     *
     * @param  int  $order_id
     * @param  int  $product_id
     * @return mixed
     */
    public function search(int $order_id, int $product_id): mixed
    {
        return OrderProduct::search($order_id, $product_id)->first();
    }

    /**
     * Повертає кількість одиниць продукту у замовленні за заданими ідентифікаторами замовлення та продукту.
     *
     * @param  int  $order_id
     * @param  int  $product_id
     * @return int
     */
    public function count(int $order_id, int $product_id): int
    {
        return OrderProduct::search($order_id, $product_id)->first()->count;
    }

    /**
     * Повертає загальну вартість продуктів у замовленні за заданим ідентифікатором замовлення.
     *
     * @param  int  $order_id
     * @return float
     */
    public function price(int $order_id): float
    {
        return OrderProduct::where('order_id', '=', $order_id)->get()->sum('price');
    }

    /**
     * Перевіряє, чи існує продукт у поточному замовленні за допомогою ідентифікатора замовлення та продукту.
     *
     * @param  Product  $product
     * @return bool
     */
    public function exist(Product $product): bool
    {
        $order = Order::where('key', '=', Cookie::get('key'))->with('products')->first();

        foreach ($order->products as $item) {
            if ($product->id === $item->id) {
                return true;
            }
        }

        return false;
    }
}
