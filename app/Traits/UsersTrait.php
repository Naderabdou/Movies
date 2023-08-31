<?php
namespace App\Traits;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

trait UsersTrait
{
    //function search
  public function DataAjax(): \Illuminate\Http\JsonResponse
  {
      //use function in model user

      $users = User::where('type','user')->select();


      return DataTables::of($users)
          ->addColumn('record_select', 'admin.users.data_table.record_select')

          ->editColumn('created_at', function (User $admin) {
              return $admin->created_at->format('Y-m-d');
          })
          ->addColumn('actions', 'admin.users.data_table.actions')
          ->rawColumns(['record_select', 'roles', 'actions'])
          ->toJson();


  }



}
