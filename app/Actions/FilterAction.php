<?php

namespace App\Actions;

use App\Models\User;
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

        if( !empty($params['user_id'])) {
            $id = User::where('email', $params['user_id'])->first()->id;
        }

        foreach ($params as $key => $value) {
            if ($value) {
                switch ($key) {
                    case 'user_id':
                        $query->where('user_id', $id);
                        break;
                    case 'name':
                        $query->where('name', 'like', '%'.$value.'%');
                        break;
                    case 'type_of_lead':
                        $query->where('type', $value);
                        break;
                    case 'category_id':
                        $query->where('category_id', '=', $value);
                        break;
                    case 'min':
                        $query->where('price', '>=', $value);
                        break;
                    case 'max':
                        $query->where('price', '<=', $value);
                        break;
                    case 'created_at':
                        $query->whereDate('created_at', '=', $value);
                        break;
                    case 'role':
                        $query->whereIn('role', $value);
                        break;
                    default:
                        break;
                }
            }
        }

        return $query;
    }
}
