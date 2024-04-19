<?php

namespace App\Facades;

use App\Services\FavoriteService;
use Illuminate\Support\Facades\Facade;

/**
 * @method toggle
 * @method isFavorite
 * @see FavoriteService
 */
class Favorite extends Facade
{
    /**
     * Отримує доступ до зареєстрованого іменованого зв'язку для фасада.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return FavoriteService::class;
    }
}
