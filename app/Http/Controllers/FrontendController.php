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

    public function contact()
    {
        return view('frontend.contact');
    }
}
