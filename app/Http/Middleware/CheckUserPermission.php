<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  $permissions  Проверяемые разрешения
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {

        if (!$request->user()->hasPermit(...$permissions))
            return response(['message' => "Доступ ограничен", 'permits' => $permissions], 403);

        return $next($request);

    }
}
