<?php

namespace App\Facades;

use App\Services\CurrencyService;
use Illuminate\Support\Facades\Facade;

/**
 * @method show
 * @see CurrencyService
 */
class Currency extends Facade
{
    /**
     * Отримує доступ до зареєстрованого іменованого зв'язку для фасада.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return CurrencyService::class;
    }
}
