<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showing extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'salon_id',
        'show_date'
    ];

    public function movies(){
        return $this->belongsTo(Movie::class);
    }

    public function salon(){
        return $this->belongsTo(Salon::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
