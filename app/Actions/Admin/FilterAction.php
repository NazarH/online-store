<?php

namespace App\Actions\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class FilterAction
{
    /**
     * Застосовує фільтри до вказаного запиту на основі параметрів запиту.
     *
     * @param Builder $query Інстанція будівника запитів
     * @return Builder Змінений екземпляр будівника запитів
     */
    public function handle(Builder $query): Builder
    {
        $params = Request::except(['_method', '_token', '_f', 'type']);

        foreach ($params as $key => $value) {
            if ($value) {
                if ($key === 'email')
                    $query->where('email', 'like', '%'.$value.'%');
                if ($key === 'name')
                    $query->where('name', 'like', '%'.$value.'%');
                if ($key === 'category_id')
                    $query->where('category_id', '=', $value);
                if ($key === 'min')
                    $query->where('price', '>=', $value);
                if ($key === 'max')
                    $query->where('price', '<=', $value);
                if ($key === 'created_at')
                    $query->whereDate('created_at', '=', $value);
                if ($key === 'role')
                    $query->whereIn('role', $value);
            }
        }

        return $query;
    }
}
