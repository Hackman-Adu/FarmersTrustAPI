<?php

namespace App\Models;

use App\Models\Ads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "users";
    protected $fillable = [
        "fullname",
        "email",
        "phone",
        "user_password",
        "image"
    ];
    protected $hidden = [
        "user_password"
    ];

    public function ads()
    {
        return $this->hasMany(Ads::class, "user_id");
    }
}