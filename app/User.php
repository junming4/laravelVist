<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 用户
 *
 * @author Latrell Chan
 *
 * @SWG\Model(id="User")
 * @SWG\Property(name="id",type="integer",description="主键")
 * @SWG\Property(name="email",type="string",description="邮箱")
 * @SWG\Property(name="phone",type="string",description="手机号")
 * @SWG\Property(name="signature",type="string",description="签名")
 * @SWG\Property(name="created_at",type="string",description="注册时间")
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone',
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
