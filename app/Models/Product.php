<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, SlugTrait;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function seo()
    {
        return $this->hasOne(Seo::class, 'model_id', 'id')
            ->where('model_type', '=', get_class($this));
    }

    public function attributes()
    {
        return $this->category->attributes();
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'product_properties');
    }
}
