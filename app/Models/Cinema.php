<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;

    protected $table = "cinemas";

    protected $fillable = [
            'title',
            'location'
    ];

    public function salons(){
        return $this->hasMany(Salon::class);
    }
}
