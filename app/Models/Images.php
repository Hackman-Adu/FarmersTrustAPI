<?php

namespace App\Models;

use App\Models\Ads;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "images";
    protected $fillable = [
        "ad_id",
        "imageUrl",
    ];

    protected $hidden = [
        "ad_id"
    ];
    public function ad()
    {
        return $this->belongsTo(Ads::class);
    }
}
