<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'imdb_id', 'title', 'year', 'poster'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
