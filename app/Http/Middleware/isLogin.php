<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // kalau belum login, redirect ke login page
        if (!Auth::check()) {
            return redirect()->route('login')->with('failed', 'Silahkan login terlebih dahulu!');
        } else {
            // kalau udah login, boleh akses
            return $next($request);
        }
    }
}