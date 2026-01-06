<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $featuredCars = Car::latest()->take(6)->get();
        return view('frontend.home', compact('featuredCars'));
    }

    public function cars(Request $request)
    {
        $query = Car::query();

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $cars = $query->latest()->paginate(9);

        return view('frontend.cars.index', compact('cars'));
    }

    public function about()
    {
        return view('frontend.about');
    }
     
    // for contact and its form
    // public function contact()
    // {
    //     return view('frontend.contact');
    // }

    //  public function submit(Request $request)
    // {
    //     // Validate input
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email',
    //         'message' => 'required|string|max:2000',
    //     ]);

        
    // // Save to database
    // ContactMessage::create($validated);

    //     // Send email via Mailtrap
    //     Mail::to('no-reply@carselect.com')->send(new ContactMail($validated));

    //     // Redirect back with success message
    //     return back()->with('success', 'Thank you! Your message has been sent.');
    // }

}
