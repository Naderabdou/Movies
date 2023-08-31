<?php
namespace App\Traits;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

trait AdminsTrait
{
    //function search
  public function DataAjax(): \Illuminate\Http\JsonResponse
  {
      //use function in model user

        $admins = User::where('type','admin')->WhenRoleId(request()->role_id)->select();

      return DataTables::of($admins)
          ->addColumn('record_select', 'admin.admins.data_table.record_select')
          ->addColumn('roles', function (User $admin) {
              return view('admin.admins.data_table.roles', compact('admin'));
          })
          ->editColumn('created_at', function (User $admin) {
              return $admin->created_at->format('Y-m-d');
          })
          ->addColumn('actions', 'admin.admins.data_table.actions')
          ->rawColumns(['record_select', 'roles', 'actions'])
          ->toJson();


  }



}
