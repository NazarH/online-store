<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes, SlugTrait;

    protected $guarded = ['id'];

    public function photos()
    {
        return $this->hasMany(Photo::class)
            ->where('model_type', '=', get_class($this))
            ->where('model_id', '=', $this->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
