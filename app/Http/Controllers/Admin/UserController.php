<?php

namespace App\Http\Controllers\Admin;

use anlutro\LaravelSettings\Facades\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Traits\PermissionTrait;
use App\Traits\UsersTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use UsersTrait;
 use PermissionTrait;
    public function __construct()
    {
        $this->model = 'users';
        $this->permission($this->model);
    }// end of constructor

    public function index()
    {
        return view('admin.users.index');
    }

    public function data(){
        return $this->DataAjax();
    }// end of data

    public function create()
    {
        return view('admin.users.create');
    }// end of create

    public function store(UserRequest $request){
        User::create($request->validated());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }// end of edit

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.users.index');
    }// end of update

    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));
    }// end of destroy

    //blukdelete
    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {
            $user = User::findorFail($recordId)->delete();
        }
        return response(__('site.deleted_successfully'));
    }// end of bulk_delete




}
