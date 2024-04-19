<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * Scope-запит для вибору користувачів з роллю адміністратора.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeByAdmin(Builder $query): Builder
    {
        return $query->where('role', '=', self::ROLE_ADMIN);
    }

    /**
     * Відношення "один до багатьох" до замовлень, що належать користувачу.
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Відношення "один до багатьох" до статей, що належать користувачу.
     *
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Повертає фото профілю користувача за його ідентифікатором.
     *
     * @param  int  $id
     * @return mixed
     */
    public function avatar(int $id): mixed
    {
        return Photo::where('model_type', 'users')->where('model_id', $id)->first();
    }

    /**
     * Відношення "багато до багатьох" до відгуків, що належать користувачу.
     *
     * @return BelongsToMany
     */
    public function review(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'user_comments');
    }
}
