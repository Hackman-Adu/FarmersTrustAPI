<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riders extends Model
{
    use HasFactory;
    protected $table = "riders";
    public $timestamps = false;
    protected $fillable = [
        "fullname",
        "phone",
        "numPlate",
        "photo"
    ];
    public function order()
    {
        return $this->hasOne(OrderDetails::class, "assigned_rider");
    }
}
