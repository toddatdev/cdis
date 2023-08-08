<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('settings', compact('user'));
    }

    public function admin()
    {
        $logged_in_user_id = Auth::user()->id;
        $users = User::where('id', '!=', $logged_in_user_id)->get(['id', 'first_name', 'email', 'role', 'is_active']);

        return view('admin', compact('users'));
    }


    public function activate($id)
    {

        $user = User::find($id);

        $user->is_active = 1;
        $user->save();

        return response()->json(['error' => false,
            'title' => 'User Activated!',
            'message' => 'User has been activated.']);
    }

    public function deactivate($id)
    {
        $user = User::find($id);

        $user->is_active = 0;
        $user->save();

        return response()->json(['error' => false,
            'title' => 'User Deactivated!',
            'message' => 'User has been deactivated.']);

    }


    public function update(Request $request)
    {
        $user_info = $request->only(['first_name', 'last_name']);

        $request->user()->update($user_info);

        return response()
            ->json(['error' => false,
                'title' => 'User Info Updated!',
                'message' => 'User information updated successfully.']);

    }

    public function logout()
    {
        if (Auth::check()) {

            $user = User::where('id', Auth::user()->id)->first();

            $user->last_activity = null;
            $user->is_logged_in = 0;
            $user->save();

            Auth::logout();

            return redirect(route('dashboard'));
        }

        return redirect(route('login'));
    }
}
