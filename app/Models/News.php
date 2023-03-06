<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $guarded  = [
        'id'
    ];

    public static $rules = [
        "user_id" => "required",
        "judul" => "required|max:255",
        "slug" => "required|max:255",
        "isi" => "required|min:10"
    ];
}
