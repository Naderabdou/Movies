<?php
namespace App\Traits;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

trait ActorsTrait
{
    //function search
  public function DataAjax(): \Illuminate\Http\JsonResponse
  {
      //use function in model user

      $Actors = Actor::withCount(['movies']);


      return DataTables::of($Actors)
          ->addColumn('record_select', 'admin.actors.data_table.record_select')
          ->addColumn('image',function (Actor $actors){
              return view('admin.actors.data_table.image',compact('actors'));
          })
          ->addColumn('related_movies', 'admin.actors.data_table.related_movies')
          ->editColumn('created_at', function (Actor $actor) {
              return $actor->created_at->format('Y-m-d');
          })


          ->addColumn('actions', 'admin.actors.data_table.actions')
          ->rawColumns(['record_select','image','related_movies','actions'])
          ->toJson();

  }
    private function delete(Actor $Actors)
    {
        $Actors->delete();

    }// end of delete




}
