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
        "user_id",
        "ad_id",
        "imageUrl",
    ];
    public function ad()
    {
        return $this->belongsTo(Ads::class);
    }
}
