<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in to access this page.');
        }


        $userRole = Auth::user()->role;


        $rolePermissions = [
            'user' => ['posts.index'],
            'author' => ['posts.index', 'posts.create', 'posts.store'],
            'admin' => ['posts.index', 'posts.create', 'posts.store', 'admin.home']
        ];


        if (!isset($rolePermissions[$userRole]) || !in_array($role, $rolePermissions[$userRole])) {
            return redirect('/dashboard')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
