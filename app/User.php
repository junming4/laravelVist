<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function owns($post)
    {
        return $this->id == $post->user_id;
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * 是否为管理员
     * @return array|int
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * @return array |int
     */
    public function hasRole($role)
    {
        if(is_string($role)){
            return $this->roles->contains('name', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }


}
