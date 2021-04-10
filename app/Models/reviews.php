<?php

namespace App\Models;

use App\Models\Ads;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "user_id",
        "ad_id",
        "review",
        "datePosted"
    ];

    protected $hidden = [
        "user_id",
        "ad_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ad()
    {
        return $this->belongsTo(Ads::class);
    }
}
