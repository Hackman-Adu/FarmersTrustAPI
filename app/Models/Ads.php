<?php
namespace App\Models;

use App\Models\User;
use App\Models\Images;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "ads";
    protected $fillable = [
        "user_id",
        "productCategory",
        "productName",
        "price",
        "location",
        "description",
        "negotiable",
        "datePosted"
    ];
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function images()
    {
        return $this->hasMany(Images::class, "ad_id");
    }
}
