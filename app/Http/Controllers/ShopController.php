<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function placeOrder(Request $request)
    {
        // Ikiwa mtumiaji hajaingia kwenye mfumo (Guest)
        if (!Auth::check()) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20',
                'password' => 'required|string|min:8',
                'address' => 'required|string',
            ]);

            // Tengeneza User Mpya (Automatic Registration)
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                // 'address' => $validated['address'], // Hakikisha column hii ipo kwenye users table
                'password' => Hash::make($validated['password']),
                'role' => 'customer', 
            ]);

            Auth::login($user);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully! Account created and logged in.'
        ]);
    }
}
