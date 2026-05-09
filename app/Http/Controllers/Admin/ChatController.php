<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
    {
        // Get all doctors and patients for the chat list
        $doctors = User::where('role', 'doctor')
            ->orWhereHas('role', function($q) { $q->where('name', 'doctor'); })
            ->get();
            
        $patients = User::where('role', 'customer')
            ->orWhereHas('role', function($q) { $q->where('name', 'customer'); })
            ->get();

        return view('admin.communication.chat', compact('doctors', 'patients'));
    }
}
