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
        
        // Ensure the role relation is loaded
        if ($user->role_id) {
            $roleName = \App\Models\Role::find($user->role_id)->name ?? null;
            
            if ($roleName) {
                switch ($roleName) {
                    case 'admin':
                        return route('admin.dashboard');
                    case 'doctor':
                        return '/doctor/dashboard';
                    case 'nurse':
                        return '/nurse/dashboard';
                    case 'pharmacist':
                        return '/pharmacist/dashboard';
                    case 'lab_tech':
                        return '/lab/dashboard';
                    case 'accountant':
                        return '/accountant/dashboard';
                    case 'receptionist':
                        return '/receptionist/dashboard';
                    case 'customer':
                        return '/patient/dashboard';
                }
            }
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
