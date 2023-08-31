<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable=['movie_id','image'];

protected $appends=['image_path'];
public function getImagePathAttribute()
    {
        return 'https://image.tmdb.org/t/p/w500/' . $this->image;
    }

    public function movie(){
        return $this->belongsTo(Movie::class);
    }
}
