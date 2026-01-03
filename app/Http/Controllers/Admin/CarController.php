<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of cars
     */
    public function index()
    {
        $cars = Car::latest()->paginate(10);

        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new car
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created car
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'model'         => 'required|string|max:255',
            'type'          => 'required|string|max:255',
            'mileage'       => 'required|numeric|min:1',
            'price_per_day' => 'required|numeric|min:1',
            'image'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('cars', 'public');
        }

        Car::create($validated);

        return redirect()
            ->route('admin.cars.index')
            ->with('success', 'Car created successfully.');
    }

    /**
     * Show the form for editing a car
     */
    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified car
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'model'         => 'required|string|max:255',
            'type'          => 'required|string|max:255',
            'mileage'       => 'required|numeric|min:1',
            'price_per_day' => 'required|numeric|min:1',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Replace image if new one uploaded
        if ($request->hasFile('image')) {
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }

            $validated['image'] = $request->file('image')
                ->store('cars', 'public');
        }

        $car->update($validated);

        return redirect()
            ->route('admin.cars.index')
            ->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified car
     */
    public function destroy(Car $car)
    {
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return redirect()
            ->route('admin.cars.index')
            ->with('success', 'Car deleted successfully.');
    }
}
