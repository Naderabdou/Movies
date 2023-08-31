<?php
namespace App\Traits;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

trait RolesTrait
{
    //function search
  public function DataAjax(): \Illuminate\Http\JsonResponse
  {
      $roles = Role::whereNotIn('name', ['super_admin', 'admin', 'user'])
          ->withCount(['users']);
      return DataTables::of($roles)
          ->addColumn('record_select', 'admin.roles.data_table.record_select')
          ->editColumn('created_at', function (Role $role) {
              return $role->created_at->format('Y-m-d');
          })
          ->addColumn('actions', 'admin.roles.data_table.actions')
          ->rawColumns(['record_select', 'actions'])
          ->toJson();


  }


  public function Curd($request,$role): void
  {
      $role->name = $request->name;
      $role->save();
      if ($request->permissions) {
          $role->syncPermissions($request->permissions);
      }
  }



}
