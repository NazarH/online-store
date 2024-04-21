<?php

namespace App\Actions\Basket;

use App\Models\Order;
use Lorisleiva\Actions\Concerns\AsAction;

class OrderCreateAction
{
    use AsAction;

    /**
     * Обробляє створення нового замовлення у кошику.
     *
     * @param string $key Унікальний ключ замовлення.
     * @param int|null $user_id Ідентифікатор користувача, якщо він авторизований.
     * @return Order Створене замовлення.
     */
    public function handle(string $key, int|null $user_id): Order
    {
        if($user_id){
            $order = Order::create([
                'type' => 'basket',
                'key' => $key,
                'user_id' => $user_id
            ]);
        } else {
            $order = Order::create([
                'type' => 'basket',
                'key' => $key,
            ]);
        }

        return $order;
    }
}
