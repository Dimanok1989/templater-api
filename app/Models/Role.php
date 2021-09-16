<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Пользователи, принадлежащие к роли
     * 
     * @return \App\Models\User
     */
    public function users()
    {

        return $this->belongsToMany(User::class, 'role_user');

    }

    /**
     * Разрешения, принадлежащие роли
     * 
     * @return \App\Models\Permission
     */
    public function permissions()
    {

        return $this->belongsToMany(Permission::class, 'role_permission');

    }

    /**
     * Добавление права роли
     * 
     * @param int $id   Идентификатор права
     * @return $this
     */
    public function addPermission($id)
    {

        if (!$this->permissions()->where('id', $id)->count())
            $this->permissions()->attach($id);

        return $this;

    }

    /**
     * Удаление права у роли
     * 
     * @param int $id   Идентификатор права
     * @return $this
     */
    public function removePermission($id)
    {

        if ($this->permissions()->where('id', $id)->count())
            $this->permissions()->detach($id);

        return $this;

    }

}
