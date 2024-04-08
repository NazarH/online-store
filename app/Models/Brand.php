<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SlugTrait, SoftDeletes;

    protected $guarded = ['id'];

    public function photo()
    {
        return $this->hasOne(Photo::class)
            ->where('model_type', '=', get_class($this))
            ->where('model_id', '=', $this->id);
    }

    public function seo()
    {
        return $this->hasOne(Seo::class)
            ->where('model_type', '=', get_class($this))
            ->where('model_id', '=', $this->id);
    }
}
