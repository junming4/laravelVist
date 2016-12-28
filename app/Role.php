<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    //
    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }

    public function givePermission(Permission $permission)
    {
        return $this->permissions->save($permission);
    }
}