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
    protected static function getFacadeAccessor()
    {
        return CurrencyService::class;
    }
}
