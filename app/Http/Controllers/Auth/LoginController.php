<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Handle post-authentication redirect by role.
     * Overrides redirect()->intended() to always go to the correct dashboard.
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('doctor')) {
            return redirect()->route('doctor.dashboard');
        }
        if ($user->hasRole('nurse')) {
            return redirect()->route('nurse.dashboard');
        }
        if ($user->hasRole('pharmacist')) {
            return redirect()->route('pharmacist.dashboard');
        }
        if ($user->hasRole('lab_tech')) {
            return redirect()->route('lab.dashboard');
        }
        if ($user->hasRole('accountant')) {
            return redirect()->route('accountant.dashboard');
        }
        if ($user->hasRole('receptionist')) {
            return redirect()->route('receptionist.dashboard');
        }
        if ($user->hasRole('customer')) {
            return redirect()->route('patient.dashboard');
        }

        return redirect()->route('home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
