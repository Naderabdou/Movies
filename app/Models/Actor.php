<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;
    protected $fillable = [
        'e_id',
        'name',
        'image',
    ];
    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return 'https://image.tmdb.org/t/p/w500/' . $this->image;
    }

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_actor');
    }
}
