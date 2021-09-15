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

        $token = $user->createToken(Authorization::getDevice($request))->plainTextToken;

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

        $token = $user->createToken(Authorization::getDevice($request))->plainTextToken;

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

    /**
     * Определение устройства
     * 
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public static function getDevice(Request $request) {

        $data = [] ;

        $agent = new \Jenssegers\Agent\Agent();

        if ($agent->isDesktop())
            $data[] = "Desktop";
        elseif ($agent->isPhone())
            $data[] = "Phone";
        elseif ($agent->isTablet())
            $data[] = "Tablet";
        elseif ($agent->isMobile())
            $data[] = "Mobile";

        if ($agent->isRobot())
            $data[] = "Robot";

        if ($robot = $agent->robot()) {
            $version = $agent->version($robot);
            $data[] = $robot . ($version ? " $version" : "");;
        }

        if ($device = $agent->device()) {
            $version = $agent->version($device);
            $data[] = $device . ($version ? " $version" : "");
        }

        if ($platform = $agent->platform()) {
            $version = $agent->version($platform);
            $data[] = $platform . ($version ? " $version" : "");
        }

        if ($browser = $agent->browser()) {
            $version = $agent->version($browser);
            $data[] = $browser . ($version ? " $version" : "");
        }

        if (!count($data))
            return $request->header('User-Agent');

        return implode(", ", $data);

    }

}
