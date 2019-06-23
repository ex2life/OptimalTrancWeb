<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function mobiles()
    {
        return $this->belongsToMany(Mobile::class);
    }

    public function routs()
    {
        return $this->belongsToMany(Rout::class);
    }

    public function avatars()
    {
        return $this->belongsToMany(Avatar::class);
    }

    public function problems()
    {
        return $this->belongsToMany(Problem::class);
    }

    /**
     * @param string|array $roles
     */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) ||
            abort(401, 'This action is unauthorized.');
    }
    /**
     * Check multiple roles
     * @param array $roles
     */
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn(‘name’, $roles)->first();
    }
    /**
     * Check one role
     * @param string $role
     */
    public function hasRole($role)
    {
        return null !== $this->roles()->where(‘name’, $role)->first();
    }


    public function gener_token()
    {
        $token = sha1(md5(strrev('soli_dlya_antresoli'.strrev($this['id'].$this['email'].'kesha').$this['id'])));
        return $token;
    }


    public function check_token($token)
    {
        return ($token==$this->gener_token());
    }

}
