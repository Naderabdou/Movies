<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Traits\ActorsTrait;
use App\Traits\PermissionTrait;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    use ActorsTrait,PermissionTrait;
    public function __construct()
    {
        $this->model = 'actors';
        $this->permission($this->model);
    }// end of constructor
    public function index()
    {
        if (request()->ajax()) {

            $actors = Actor::where('name', 'like', '%' . request()->search . '%')
                ->limit(10)
                ->get();

            $results = [];

            $results[] = ['id' => '', 'text' => 'All Actors'];

            foreach ($actors as $actor) {

                $results[] = ['id' => $actor->id, 'text' => $actor->name];

            }//end of for each

            return json_encode($results);

        }//end of if
        return view('admin.actors.index');
    }// end of index

    public function data()
    {
        return $this->DataAjax();
    }// end of data

    public function destroy(Actor $actor)
    {
        $this->delete($actor);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy
    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $actor = Actor::FindOrFail($recordId);
            $this->delete($actor);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

}
