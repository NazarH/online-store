<?php

namespace App\Models;

use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'attribute_category');
    }

    public function belongsToCategories()
    {
        return $this->categories()->pluck('id')->toArray();
    }
}
