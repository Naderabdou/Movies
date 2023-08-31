<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Traits\GenresTrait;
use App\Traits\PermissionTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GenreController extends Controller
{
    use PermissionTrait, GenresTrait;

    public function __construct()
    {
        $this->model = 'genres';
        $this->permission($this->model);
    }// end of constructor

    public function index()
    {
        return view('admin.genres.index');

    }// end of index

    public function data()
    {
        return $this->DataAjax();

    }// end of data

    public function destroy(Genre $genre)
    {
        $this->delete($genre);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $genre = Genre::FindOrFail($recordId);
            $this->delete($genre);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

}
