<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'salon_id',
        'group',
        'seat_no'
    ];

    public function salon(){
        return $this->belongsTo(Salon::class);
    }
}
