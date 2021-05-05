<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class passwordReset extends Model
{
    use HasFactory;
    protected $table = "password_resets";
    public $timestamps = false;
    protected $fillable = [
        'user_id', "code",
    ];
}