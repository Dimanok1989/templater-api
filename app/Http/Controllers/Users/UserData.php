<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserData extends Controller
{
    
    /**
     * Вывод всех данных пользователя для первоначальной загрузки страницы
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function user(Request $request)
    {

        $user = UserData::getUserData($request->user());

        return response()->json($user);

    }

    /**
     * Формирование данных пользователя
     * 
     * @param \App\Models\User $user
     * @return object
     */
    public static function getUserData(\App\Models\User $user)
    {

        // Роли пользователя
        $user->roles = $user->roles;

        // Права пользователя
        $user->permits = $user->getAllPermissions();

        return $user;

    }

}
