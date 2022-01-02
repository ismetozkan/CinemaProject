<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;

    protected $table = "salons";

    protected $fillable = [
        'cinema_id',
        'title',
        'code'
    ];

    public function cinema(){
        return $this->belongsTo(Cinema::class);
    }

    public function showings(){
        return $this->hasMany(Showing::class);
    }

    public function seats(){
        return $this->hasMany(Seat::class);
    }
}
