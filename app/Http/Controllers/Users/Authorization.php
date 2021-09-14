<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;

class Authorization extends Controller
{

    /**
     * Регистрация нового пользователя
     * 
     * @param \App\Http\Requests\UserRegistrationRequest $request
     * @return response
     */
    public static function registration(UserRegistrationRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken($request->header('User-Agent'))->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);

    }
    
    /**
     * Авторизация пользователя и выдача токена
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function login(Request $request)
    {

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return response()->json(['message' => "Неверный логин или пароль"], 400);

        $user = Auth::user();

        $token = $user->createToken($request->header('User-Agent'))->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);

    }

    /**
     * Деавторизация пользователя
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => "Деавторизация произведена",
        ]);

    }

}
