<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        
        // Redirect based on role
        if ($user->role === 'admin' || (is_object($user->role) && $user->role->name === 'admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'doctor' || (is_object($user->role) && $user->role->name === 'doctor')) {
            return redirect()->route('doctor.dashboard');
        } elseif ($user->role === 'nurse' || (is_object($user->role) && $user->role->name === 'nurse')) {
            return redirect()->route('nurse.dashboard');
        } elseif ($user->role === 'pharmacist' || (is_object($user->role) && $user->role->name === 'pharmacist')) {
            return redirect()->route('pharmacist.dashboard');
        } elseif ($user->role === 'lab_tech' || (is_object($user->role) && $user->role->name === 'lab_tech')) {
            return redirect()->route('lab.dashboard');
        } elseif ($user->role === 'accountant' || (is_object($user->role) && $user->role->name === 'accountant')) {
            return redirect()->route('accountant.dashboard');
        } elseif ($user->role === 'receptionist' || (is_object($user->role) && $user->role->name === 'receptionist')) {
            return redirect()->route('receptionist.dashboard');
        } elseif ($user->role === 'customer' || (is_object($user->role) && $user->role->name === 'customer')) {
            return redirect()->route('patient.dashboard');
        }

        return view('home');
    }
}
