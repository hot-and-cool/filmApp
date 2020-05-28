<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Clip extends Model
{
    protected $fillable = [
        'movie_id',
        'user_id',
        'title',
        'poster_path',
    ];

    protected $perPage = 15;

    public function getFirstClip($movieId)
    {
        return $this->where('user_id', Auth::id())->where('movie_id', $movieId)->first();
    }
}
