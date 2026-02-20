<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function contact()
    {
        return view('frontend.contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($validated);

        // Keep email sending non-blocking for the user flow.
        try {
            Mail::raw(
                "New contact message from {$validated['name']} ({$validated['email']}):\n\n{$validated['message']}",
                function ($mail) {
                    $mail->to('support@carbooking.test')
                        ->subject('New Contact Message');
                }
            );
        } catch (\Throwable $e) {
            report($e);
        }

        return back()->with('success', 'Thank you! Your message has been sent.');
    }
}
