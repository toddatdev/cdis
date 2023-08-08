<?php

namespace App\Http\Traits;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

trait  IsInactiveUser
{
    public function isInactiveUser($request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->is_active) {

            return true;
        }

        return false;
    }

    protected
    function sendIsInactiveUserResponse()
    {

        throw ValidationException::withMessages([

            $this->username() => [trans('auth.isInactiveUser')],
        ]);
    }

}
