<?php

namespace App\Models;

use App\Models\Ads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = "users";
    protected $fillable = [
        "fullname",
        "email",
        "verified",
        "phone",
        "user_password",
        "image"
    ];
    protected $hidden = [
        "user_password",
    ];

    public function ads()
    {
        return $this->hasMany(Ads::class, "user_id")->orderBy("id", "DESC")->limit(3);
    }
    //for counting the number of ads for a particular user
    public function countAds()
    {
        return $this->hasMany(Ads::class, "user_id");
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }
}
