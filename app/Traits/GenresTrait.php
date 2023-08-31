<?php
namespace App\Traits;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Genre;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

trait GenresTrait
{
    //function search
  public function DataAjax(): \Illuminate\Http\JsonResponse
  {
      //use function in model user

      $genres = Genre::withcount('movies');

      return DataTables::of($genres)
          ->addColumn('record_select', 'admin.genres.data_table.record_select')
          ->addColumn('related_movies', 'admin.genres.data_table.related_movies')
          ->editColumn('created_at', function (Genre $genre) {
              return $genre->created_at->format('Y-m-d');
          })
          ->addColumn('actions', 'admin.genres.data_table.actions')
          ->rawColumns(['record_select', 'related_movies', 'actions'])
          ->toJson();

  }
    private function delete(Genre $genre)
    {
        $genre->delete();

    }// end of delete




}
