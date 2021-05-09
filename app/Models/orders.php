<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;

    protected $table = "orders";
    protected $fillable = ['buyer_id', 'seller_id', "ad_id", "status"];

    public function orderDetails()
    {
        return $this->hasOne(orderDetails::class, "order_id");
    }

    public function buyer()
    {
        return $this->belongsTo(User::class);
    }
    public function seller()
    {
        return $this->belongsTo(User::class);
    }
}
