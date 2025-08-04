<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     * Kullanıcının giriş yapıp yapmadığını kontrol eder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Eğer kullanıcı giriş yapmamışsa redirectTo() ile döner
        if (! Auth::check()) {
            // Eğer istek JSON bekliyorsa 401 döner, yoksa login sayfasına yönlendirir
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 401);
            }
            return redirect($this->redirectTo($request));
        }

        return $next($request);
    }

    /**
     * Kullanıcı giriş yapmamışsa nereye yönlendirilecek?
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Login sayfanın rotası burada olmalı
        if (! $request->expectsJson()) {
            return route('dashboard.login');
        }
    }
}
