<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Traits\PermissionTrait;
use App\Traits\RolesTrait;
use http\Env\Response;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    use PermissionTrait;
    use RolesTrait;
    public function __construct()
    {
        $this->model = 'roles';
        $this->permission($this->model);
    }// end of constructor


    public function index()
    {
        return view('admin.roles.index');
    }


    public function data()
    {
        return $this->DataAjax();
    }// end of data




    public function create()
    {
        return view('admin.roles.create');
    }// end of create



    public function store(RoleRequest $request)
    {
      $role= new Role();
      $this->Curd($request,$role);
          //flash message
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.roles.index');

    }// end of store



    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }// end of edit



    public function update(RoleRequest $request, Role $role)
    {
        $this->Curd($request,$role);
        //flash message
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.roles.index');
    }// end of update



    public function destroy(Role $role)
    {
        $role->delete();
        //flash message
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }// end of delete



    public function bulkDelete()
    {

        foreach (json_decode(request()->record_ids) as $recordId) {

            $role = Role::FindOrFail($recordId)->delete();

        }// end of for each
        session()->flash('success', __('site.deleted_successfully'));

        return response(__('site.deleted_successfully'));

    }// end of bulk_delete

}
