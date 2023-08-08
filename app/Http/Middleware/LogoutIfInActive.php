<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class LogoutIfInActive
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            //if user is_logged in is set to zero and last activity is null then logout the user
            if (Auth::user()->is_logged_in === 0 && Auth::user()->last_activity === null) {

                return redirect(route('users.logout'));
            }

            if (Auth::user()->last_activity < Carbon::now()->subMinutes(1)->format('Y-m-d H:i:s')) {

                $user = Auth::user();
                $user->last_activity = new \DateTime;
                $user->timestamps = false;
                $user->save();
            }

        }

        return $next($request);
    }
}
