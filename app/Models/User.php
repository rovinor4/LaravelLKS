<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded  = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [
        "name" => "max:255",
        "email" => "required|email|max:255|unique:users",
        "password" => "required|min:8"
    ];


    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($user) {
    //         $uuid = Str::uuid();
    //         $token = hash('sha256', $uuid);
    //         $user->remember_token = $token;
    //     });
    // }
}
