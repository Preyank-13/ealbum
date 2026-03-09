<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class credit extends Model
{
    // Table ka naam plural ('credits') hota hai
    protected $table = 'credits';

    // In fields ko mass assignment ke liye allow karein
    protected $fillable = [
        'user_id', 
        'order_id', 
        'purchase_date', 
        'album_name', 
        'credits', 
        'amount', 
        'payment_type', 
        'message', 
        'status'
    ];
}