<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;

class UserCarController extends Controller
{
    /**
     * Display available cars for users
     */
    public function index()
    {
        $cars = Car::query()
            ->where('is_available', true)
            ->latest()
            ->paginate(9);

        return view('user.cars.index', compact('cars'));
    }

    /**
     * Show single car details (optional but useful)
     */
    public function show(Car $car)
    {
        if (!$car->is_available) {
            return redirect()
                ->route('user.cars.index')
                ->with('error', 'This car is not available.');
        }

        return view('user.cars.show', compact('car'));
    }
}
