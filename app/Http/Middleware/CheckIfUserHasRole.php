<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user();

        $hasRequiredRole = false;
        if ($role == 'admin') {
            $hasRequiredRole = $user->isAdmin();
        } elseif ($role == 'researcher') {
            $hasRequiredRole = $user->isResearcher();
        } elseif ($role == 'respondent') {
            $hasRequiredRole = $user->isRespondent();
        } else {
            abort(404, 'Role not specified or not found');
        }

        if (!$hasRequiredRole) {
            //not allowed
            abort(403, 'Unauthorized');
        }

        //allowed
        return $next($request);
    }
}
