<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clip extends Model
{
    protected $fillable = [
        'movie_id',
        'user_id',
    ];
}
