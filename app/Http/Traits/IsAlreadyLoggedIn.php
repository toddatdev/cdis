<?php

namespace App\Http\Traits;

use App\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

trait IsAlreadyLoggedIn
{
    public function hasAlreadyLoggedIn($request)
    {
        $wait_time = 20;

        $user = User::where('email', $request->email)->first();

        if (!$user->is_logged_in) {

            $user->is_logged_in = true;
            $user->save();

            return false;
        }


        //record user login attempt if user is already logged in
        if ($user->last_activity < Carbon::now()->subMinutes($wait_time)->format('Y-m-d H:i:s')) {
            $user->last_activity = new \DateTime;
            $user->save();

            return false;
        }

        return ($wait_time - $user->last_activity->diffInMinutes(Carbon::now()));
    }

    protected
    function sendAlreadyLoginResponse($minutes)
    {
        throw ValidationException::withMessages([

            $this->username() => [trans('auth.alreadyLoggedIn', ['minutes' => $minutes])],
        ]);
    }

}
