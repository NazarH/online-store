<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Scope-запит для пошуку запису в таблиці order_products за ідентифікаторами замовлення та продукту.
     *
     * @param  Builder  $query
     * @param  int  $order_id Ідентифікатор замовлення.
     * @param  int  $product_id Ідентифікатор продукту.
     * @return Builder
     */
    public function scopeSearch(Builder $query, int $order_id, int $product_id): Builder
    {
        return $query->where('order_id', '=', $order_id)->where('product_id', '=', $product_id);
    }
}
