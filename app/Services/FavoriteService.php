<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\Product;

class FavoriteService
{
    public function toggle($item, $id = null): bool
    {
        if ($this->isFavorite($item)) {
            $favorite = Favorite::search($item)->first();

            $favorite->delete();

            return false;
        } else {
            Favorite::create([
                'model_id' => $item->id,
                'model_type' => get_class($item),
                'user_id' => $id ? $id : auth()->id()
            ]);

            return true;
        }
    }

    public function isFavorite($item): bool
    {
        return Favorite::search($item)->exists();
    }
}
