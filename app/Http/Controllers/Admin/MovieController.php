<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Traits\MoviesTrait;
use App\Traits\PermissionTrait;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    use PermissionTrait, MoviesTrait;

    public function __construct()
    {
        $this->model = 'movies';
        $this->permission($this->model);
    }// end of constructor

    public function index()
    {
        $actor = null;
       $genres=Genre::all();
       if (request()->actor_id) {
           $actor = Actor::find(request()->actor_id);
         }

        return view('admin.movies.index',compact('genres','actor'));
    }// end of index

    public function data()
    {
        return $this->DataAjax();

    }// end of data

    //show
    public function show(Movie $movie)
    {
        $movie->load('genres','actors','images');
        return view('admin.movies.show',compact('movie'));
    }// end of show

    public function destroy(Movie $movie)
    {
        $this->delete($movie);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $movie = Movie::FindOrFail($recordId);
            $this->delete($movie);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

}
