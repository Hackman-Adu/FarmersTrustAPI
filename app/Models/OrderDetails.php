<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $table = "order_details";
    public $timestamps = false;
    protected $fillable = [
        "order_id",
        "product",
        "total_price",
        "quantity",
        "orderType",
        "location",
        "phone"
    ];

    public function order()
    {
        return $this->belongsTo(orders::class);
    }
}
