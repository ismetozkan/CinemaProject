<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaToMovie extends Model
{
    use HasFactory;

    protected $table = 'cinema_to_movie';

    protected $fillable = [
        'cinema_id',
        'movie_id',
        'start',
        'end'
    ];
    public function cinemas(){
        return $this->hasOne(Cinema::class);
    }

    public function movies(){
        return $this->hasOne(Movie::class);
    }

}
