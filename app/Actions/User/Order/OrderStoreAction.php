<?php

namespace App\Actions\User\Order;

use App\Events\ConfirmOrder;
use App\Events\NewOrderUser;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class OrderStoreAction
{
    use AsAction;

    /**
     * Обробляє оновлення замовлення з переданими даними.
     *
     * @param array $data Масив даних для оновлення замовлення.
     * @param Order $order Замовлення, яке необхідно оновити.
     * @return void
     */
    public function handle(array $data, Order $order): void
    {
        $user = User::where('email', '=', $data['email'])->first();

        if (empty($user)) {
            $password = 'pass'.rand(1, 10000).'word';

            $data['password'] = bcrypt($password);
            $data['remember_token'] = Str::random(10);

            $user = User::create($data);

            event(new NewOrderUser($user, $password));
        }

        $data['user_id'] = $user->id;

        $order->update($data);

        event(new ConfirmOrder($user));
    }
}
