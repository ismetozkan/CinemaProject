<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class    Ticket extends Model
{
    use HasFactory;

    protected $fillable =[
        'showing_id',
        'user_id',
        'seat_id',
        'detail',
        'price',
        'type',
        'payment_status',
        'payment_method'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function showing(){
        return $this->belongsTo(Showing::class);
    }
}
