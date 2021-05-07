<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class account_activation extends Model
{
    use HasFactory;

    protected $table = "account_activations";
    public $timestamps = false;
    protected $fillable = [
        'phone', "code",
    ];
}
