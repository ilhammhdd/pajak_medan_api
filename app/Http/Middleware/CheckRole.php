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
            $customer = $request->user()->customer;
            $profile = $request->user()->customer->profile;
            $request->attributes->add([
                'customer' => $customer,
                'profile' => $profile
            ]);
            return $next($request);
        }

        return response()->json([
            'message' => 'Your role isn\'t authorized to do this action',
            'your_role' => $request->user()->role->name
        ]);
    }
}
