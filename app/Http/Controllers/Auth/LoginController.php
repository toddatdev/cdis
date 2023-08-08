<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\IsAlreadyLoggedIn;
use App\Http\Traits\IsInactiveUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    use IsAlreadyLoggedIn;
    use IsInactiveUser;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        //attempt login
        if (!$this->attemptLogin($request)) {

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }

        //logout user so that  can test the other conditions
        $this->guard()->logout();
        $request->session()->invalidate();


        if (!$this->isInactiveUser($request)) {

            return $this->sendIsInactiveUserResponse();
        }


        //check to see if user is already logged in
        if ($minutes = $this->hasAlreadyLoggedIn($request)) {

            return $this->sendAlreadyLoginResponse($minutes);
        }

        if ($this->attemptLogin($request)) {

            return $this->sendLoginResponse($request);
        }
    }


    protected function authenticated(Request $request, $user)
    {
        $county = $user->county->name;
        $countyId = $user->county->id;
        $district = $user->county->district;

        session()->put('county', strtolower($county));
        session()->put('county_id', $countyId);
        session()->put('district', strtolower($district));
    }


}
