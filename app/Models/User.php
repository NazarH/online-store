<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const ROLE_ADMIN = 'admin';
    const ROLE_CLIENT= 'client';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopeByAdmin(Builder $query)
    {
        return $query->where('role', '=', self::ROLE_ADMIN);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function avatar($id)
    {
        return Photo::where('model_type', 'users')->where('model_id', $id)->first();
    }

    public function selected()
    {
        return $this->belongsToMany(Product::class, 'select_products');
    }

    public function review()
    {
        return $this->belongsToMany(Comment::class, 'user_comments');
    }
}
