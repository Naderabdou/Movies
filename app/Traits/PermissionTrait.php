<?php
namespace App\Traits;


trait PermissionTrait
{
    //function search
  public function permission($model)

  {
      ;

        $this->middleware('permission:'.'read_'.$this->model)->only(['index']);
        $this->middleware('permission:'.'create_'.$this->model)->only(['create', 'store']);
        $this->middleware('permission:'.'update_'.$this->model)->only(['edit', 'update']);
        $this->middleware('permission:'.'delete_'.$this->model)->only(['delete', 'bulk_delete']);


  }



}
