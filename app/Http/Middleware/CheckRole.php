<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($request->user()->role->name == $role) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Your role isn\'t authorized to do this action',
            'your_role' => $request->user()->role->name
        ]);
    }
}
