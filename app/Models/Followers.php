<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
    use HasFactory;

    protected $table = "followers";
    public $timestamps = false;

    protected $fillable = [
        "user_id",
        "follower_id"
    ];
}
