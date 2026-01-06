<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function contact()
    {
        return view('frontend.contact');
    }

     public function submit(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        
    // Save to database
    ContactMessage::create($validated);

        // Send email via Mailtrap
        Mail::to('no-reply@carselect.com')->send(new ContactMail($validated));

        // Redirect back with success message
        return back()->with('success', 'Thank you! Your message has been sent.');
    }

}
