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
     * Get the post-login redirect path.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return route('admin.dashboard');
        }

        if ($user->hasRole('doctor')) {
            return route('doctor.dashboard');
        }
        
        if ($user->hasRole('nurse')) {
            return route('nurse.dashboard');
        }
        
        if ($user->hasRole('pharmacist')) {
            return route('pharmacist.dashboard');
        }
        
        if ($user->hasRole('lab_tech')) {
            return route('lab.dashboard');
        }
        
        if ($user->hasRole('accountant')) {
            return route('accountant.dashboard');
        }
        
        if ($user->hasRole('receptionist')) {
            return route('receptionist.dashboard');
        }
        
        if ($user->hasRole('customer')) {
            return route('patient.dashboard');
        }

        return '/home';
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
