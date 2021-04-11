<?php

namespace App\Models;

use App\Models\Ads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carts extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "carts";

    protected $fillable = [
        "user_id",
        "ad_id",
    ];

    public function ad()
    {
        return $this->belongsTo(Ads::class, "ad_id");
    }
}
