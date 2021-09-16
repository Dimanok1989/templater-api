<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * Роли, имеющие право
     * 
     * @return \App\Models\Role
     */
    public function roles()
    {

        return $this->belongsToMany(Role::class);

    }

    /**
     * Пользователи, имеющие право
     * 
     * @return \App\Models\User
     */
    public function users()
    {

        return $this->belongsToMany(User::class);

    }

}
