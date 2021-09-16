<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\Users\UserRolesAndPermissions;

/**
 * @method bool \App\Http\Controllers\Users\UserRolesAndPermissions hasPermit(...$permissions)
 * @method array \App\Http\Controllers\Users\UserRolesAndPermissions getAllPermissions()
 * @method $this \App\Http\Controllers\Users\UserRolesAndPermissions addRole(int $id)
 * @method $this \App\Http\Controllers\Users\UserRolesAndPermissions removeRole(int $id)
 * @method $this \App\Http\Controllers\Users\UserRolesAndPermissions addPermission(int $id)
 * @method $this \App\Http\Controllers\Users\UserRolesAndPermissions removePermission(int $id)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UserRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Роли, принадлежащие пользователю
     * 
     * @return \App\Models\Role
     */
    public function roles()
    {

        return $this->belongsToMany(Role::class);

    }

    /**
     * Права, принадлежащие пользователю
     * 
     * @return \App\Models\Permission
     */
    public function permissions()
    {

        return $this->belongsToMany(Permission::class, 'user_permission');

    }

}
