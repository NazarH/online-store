<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, SoftDeletes, SlugTrait, NodeTrait;

    protected $guarded = ['id'];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_category');
    }

    public function scopeParent(Builder $query, $id)
    {
        return $query->where('parent_id', $id);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
