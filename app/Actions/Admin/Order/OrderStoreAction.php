<?php

namespace App\Actions\Admin\Order;

use App\Events\ConfirmOrder;
use App\Events\NewOrderUser;
use App\Models\Order;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class OrderStoreAction
{
    use AsAction;

    /**
     * Обробляє створення замовлення.
     *
     * @param array $data Дані для створення замовлення.
     * @return void
     */
    public function handle(array $data): void
    {
        $user = User::where('email', '=', $data['email'])->first();

        if (empty($user)) {
            $password = 'pass'.rand(1, 10000).'word';

            $data['password'] = bcrypt($password);

            $user = User::create($data);

            event(new NewOrderUser($user, $password));
        }

        $data['user_id'] = $user->id;

        Order::create($data);

        event(new ConfirmOrder($user));
    }
}
