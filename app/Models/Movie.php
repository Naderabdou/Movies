<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'e_id', 'title', 'description', 'poster', 'banner', 'release_date', 'vote',
        'vote_count', 'type'
    ];
   /* protected $casts = [
        'release_date' => 'date',
    ];*/
    protected $appends = ['poster_path', 'banner_path'];
//functions
    public function getPosterPathAttribute()
    {
          return 'https://image.tmdb.org/t/p/w500/' . $this->poster;
    }

    public function getBannerPathAttribute()
    {
        return 'https://image.tmdb.org/t/p/w500/' . $this->banner;
    }

    public function isFavorite()
    {
        /*if (auth()->check()) {
            return auth()->user()->favoriteMovies()->where('movie_id', $this->id)->exists();
        }
        return false;*/
        return in_array(auth()->user()->id,$this->favoriteByUsers->pluck('id')->toArray());
    }

    //end of functions


        ///relation
        public function genres(){
        return $this->belongsToMany(Genre::class,'movie_genre');
     }
        public function actors(){
            return $this->belongsToMany(Actor::class,'movie_actor');
        }
        public function images(){
            return $this->hasMany(Image::class);
        }
        public function favoriteByUsers(){
            return $this->belongsToMany(User::class,'user_favorite_movie','movie_id','user_id');
        }

        //end of relation


    //scopes
    public function scopeWhenGenreId($query, $genreId)
    {
        return $query->when($genreId, function ($q) use ($genreId) {

            return $q->whereHas('genres', function ($qu) use ($genreId) {

                return $qu->where('genres.id', $genreId);

            });

        });

    }// end of scopeWhenGenreId

    //scopeWhenActorId
    public function scopeWhenActorId($query, $actorId)
    {
        return $query->when($actorId, function ($q) use ($actorId) {

            return $q->whereHas('actors', function ($qu) use ($actorId) {

                return $qu->where('actors.id', $actorId);

            });

        });

    }// end of scopeWhenActorId

    //scopeWhenType
    public function scopeWhenType($query, $type)
    {
        return $query->when($type, function ($q) use ($type) {

            return $q->where('type', $type);

        });

    }// end of scopeWhenType

    //scopeWhenSearch
    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {

            return $q->where('title', 'like', '%'.$search.'%');

        });

    }// end of scopeWhenSearch

    //scopeFavorite
    public function scopeWhenFavoriteById($query,$favoriteId)
    {
        return $query->when($favoriteId, function ($q) use ($favoriteId) {
            return $q->whereHas('favoriteByUsers', function ($qu) use ($favoriteId) {
                return $qu->where('id', $favoriteId);
            });
        });

    }// end of scopeFavoriteById



   //end of scopes

}
