<?php
namespace App\Traits;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

trait MoviesTrait
{
    //function search
  public function DataAjax(): \Illuminate\Http\JsonResponse
  {
      //use function in model user

      $movies = Movie::whenGenreId(request()->genre_id)
          ->whenActorId(request()->actor_id)
          ->whenType(request()->type)
          ->withCount('favoriteByUsers')
          ->with('genres');


      return DataTables::of($movies)
          ->addColumn('record_select', 'admin.movies.data_table.record_select')
          ->addColumn('genres',function (Movie $movies){
              return view('admin.movies.data_table.genres',compact('movies'));
          })
          ->addColumn('poster',function (Movie $movies){
              return view('admin.movies.data_table.poster',compact('movies'));
          })

          ->addColumn('vote','admin.movies.data_table.vote')
          ->addColumn('related_movies', 'admin.movies.data_table.related_movies')

          ->addColumn('actions', 'admin.movies.data_table.actions')
          ->rawColumns(['record_select', 'related_movies', 'actions','vote'])
          ->toJson();

  }
    private function delete(Movie $movies)
    {
        $movies->delete();

    }// end of delete




}
