<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeSearch(Builder $query, $item)
    {
        return $query->where('user_id', auth()->id())
            ->where('model_id', $item->id)
            ->where('model_type', get_class($item));
    }

    public function product(): hasOne
    {
        return $this->hasOne(Product::class, 'id', 'model_id');
    }

    public function article(): hasOne
    {
        return $this->hasOne(Article::class, 'id', 'model_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }
}
