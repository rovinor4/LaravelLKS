<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $guarded  = [
        'id'
    ];

    public static $rules = [
        "user_id" => "required|exists:users,id|integer",
        "news_id" => "required|exists:news,id",
        "star" => "required|min:1|max:6|integer",
        "comment" => "min:4"
    ];
}
