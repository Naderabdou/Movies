<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Role;
use App\Models\User;
use App\Traits\AdminsTrait;
use App\Traits\PermissionTrait;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use PermissionTrait;
    use AdminsTrait;
    public function __construct()
    {
        $this->model = 'admins';
        $this->permission($this->model);
    }// end of constructor

    public function index(){
        $roles = Role::whereNotIn('name', ['super_admin', 'admin', 'user'])->get();

        return view('admin.admins.index', compact('roles'));
    }

    public function data()
    {

        return $this->DataAjax();
    }// end of data

    public function create()
    {
        $roles = Role::whereNotIn('name', ['super_admin', 'admin'])->get();

        return view('admin.admins.create', compact('roles'));
    }// end of create

    public function store(AdminRequest $request){


        $data = $request->validated();
       $admin= User::create($data);
        $admin->roles()->attach([$request->role_id]);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.admins.index');

    }
    public function edit(User $admin)
    {
        $roles = Role::whereNotIn('name', ['super_admin', 'admin'])->get();

        return view('admin.admins.edit', compact('admin', 'roles'));

    }// end of edit

    public function update(AdminRequest $request, User $admin)
    {
        $admin->update($request->validated());
        $admin->syncRoles(['admin', $request->role_id]);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.admins.index');

    }// end of update

    public function destroy($id)

    {
        $user = User::FindOrFail($id);
        $user->delete();
      $user->roles()->detach();

        //flash message
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }// end of delete


    public function bulkDelete()
    {

        foreach (json_decode(request()->record_ids) as $recordId) {

           $user = User::FindOrFail($recordId);
              $user->roles()->detach();
              $user->delete();


        }// end of for each
        session()->flash('success', __('site.deleted_successfully'));

        return response(__('site.deleted_successfully'));

    }// end of bulk_delete


}
