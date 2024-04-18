<?php

namespace App\Facades;

use App\Services\OrderService;
use Illuminate\Support\Facades\Facade;

/**
 * @method onlinePayment
 * @see OrderService
 */
class Order extends Facade
{
    /**
     * Отримує доступ до зареєстрованого іменованого зв'язку для фасада.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return OrderService::class;
    }
}
