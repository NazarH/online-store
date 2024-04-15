<?php

namespace App\Facades;

use App\Services\BasketService;
use Illuminate\Support\Facades\Facade;

/**
 * @method show
 * @see BasketService
 */
class Basket extends Facade
{
    /**
     * Отримує доступ до зареєстрованого іменованого зв'язку для фасада.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return BasketService::class;
    }
}
