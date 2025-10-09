<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ... $roles): Response
    {
        if (!Auth::check()) {
            return redirect('/')->withErrors([
                'email' => 'Silahkan Login Terlebih Dahulu',
            ]);
        }
        $roleName = Role::find(Auth::user()->role_id)->name;
        if  (!in_array($roleName, $roles))
            {
                return redirect('/dashboard');

            }
        
        
        return $next($request);
    }
}
