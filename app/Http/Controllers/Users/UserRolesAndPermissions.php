<?php

namespace App\Http\Controllers\Users;

trait UserRolesAndPermissions
{
    
    /**
     * Определение разрешений у пользователя
     * через личные права и права его одной из роли
     * 
     * @return bool
     */
    public function hasPermit(...$permissions)
    {

        if ($this->permissions()->whereIn('permission', $permissions)->count())
            return true;

        foreach ($this->roles as $role) {
            if ($role->permissions()->whereIn('permission', $permissions)->count())
                return true;
        }

        return false;

    }

    /**
     * Массив всех прав пользователя
     * 
     * @return array
     */
    public function getAllPermissions()
    {

        $permissions = $this->permissions->pluck('permission')->toArray();

        foreach ($this->roles as $role) {

            foreach ($role->permissions()->whereNotIn('permission', $permissions)->get() as $row)
                $permissions[] = $row->permission;

        }

        return array_unique($permissions, SORT_STRING);

    }

    /**
     * Добавление роли пользователю
     * 
     * @param int $id   Идентификатор роли
     * @return $this
     */
    public function addRole($id)
    {

        if (!$this->roles()->where('id', $id)->count())
            $this->roles()->attach($id);

        return $this;

    }

    /**
     * Удаление роли у пользователю
     * 
     * @param int $id   Идентификатор роли
     * @return $this
     */
    public function removeRole($id)
    {

        if ($this->roles()->where('id', $id)->count())
            $this->roles()->detach($id);

        return $this;

    }

    /**
     * Добавление права пользователю
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
     * Удаление права у пользователю
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
