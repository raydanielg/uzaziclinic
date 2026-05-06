<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            ContactMessage::create($validated);
            return response()->json(['success' => true, 'message' => 'Thank you! Your message has been sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Sorry, something went wrong. Please try again later.'], 500);
        }
    }
}
