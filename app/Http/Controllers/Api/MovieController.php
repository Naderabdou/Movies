<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MoviesRequest;
use App\Http\Resources\ActorResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    public function index()
    {

        $movies = Movie::whenType(request()->type)
            ->whenSearch(request()->search)
            ->whenGenreId(request()->genre)
            ->whenActorId(request()->actor)
            ->whenFavoriteById(auth()->user()->id)
            ->with('genres')
            ->paginate(10);

        $data['movies'] = MovieResource::collection($movies)->response()->getData(true);
        return response()->api($data);
    }
    public function toggelFav(MoviesRequest $request){

          //check if movie id is exist
        $movie = Movie::find($request->movie_id);
        if (!$movie){
            return response()->apiError(__('movies.movie_not_found'), 1, 404);
        }

        auth()->user()->favoriteMovies()->toggle($request->movie_id);
        return response()->api(null, __('movies.toggle_fav_add'), 0,200);
    }


    public function images($movie)
    {
        $movie = Movie::find($movie);
        if (!$movie){
            return response()->apiError(__('movies.movie_not_found'), 1, 404);
        }
        return response()->api(ImageResource::collection($movie->images));

    }// end of images

    public function actors($movie)
    {
        $movie = Movie::find($movie);
        if (!$movie){
            return response()->apiError(__('movies.movie_not_found'), 1, 404);
        }
        return response()->api(ActorResource::collection($movie->actors));

    }// end of actors

    public function relatedMovies($movie)
    {
        $movie = Movie::find($movie);
        if (!$movie){
            return response()->apiError(__('movies.movie_not_found'), 1, 404);
        }
        $movies = Movie::whereHas('genres', function ($q) use ($movie) {
            return $q->whereIn('name', $movie->genres()->pluck('name'));
        })
            ->with('genres')
            ->where('id', '!=', $movie->id)
            ->paginate(10);
        $data['movies'] = MovieResource::collection($movies)->response()->getData(true);
          return response()->api($data);

    }// end of relatedMovies


 public function isFavorite($movie)
    {
        $movie = Movie::find($movie);
        if (!$movie){
            return response()->apiError(__('movies.movie_not_found'), 1, 404);
        }
        return response()->api(['is_favorite' => $movie->isFavorite()]);
    }// end of isFavorite


    //end of functions

}
