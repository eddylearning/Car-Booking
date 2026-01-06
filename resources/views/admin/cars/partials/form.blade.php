{{-- resources/views/admin/cars/partials/form.blade.php --}}

@php
    $car = $car ?? null;
@endphp

<div class="row g-3">

    {{-- Car Name --}}
    <div class="col-md-6">
        <label for="name" class="form-label">Car Name</label>
        <input type="text" name="name" id="name" class="form-control"
               value="{{ old('name', $car->name ?? '') }}">
        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Model --}}
    <div class="col-md-6">
        <label for="model" class="form-label">Model</label>
        <input type="text" name="model" id="model" class="form-control"
               value="{{ old('model', $car->model ?? '') }}">
        @error('model') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Type --}}
    <div class="col-md-4">
        <label for="type" class="form-label">Type</label>
        <input type="text" name="type" id="type" class="form-control"
               value="{{ old('type', $car->type ?? '') }}">
        @error('type') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Mileage --}}
    <div class="col-md-4">
        <label for="mileage" class="form-label">Mileage</label>
        <input type="number" name="mileage" id="mileage" class="form-control"
               value="{{ old('mileage', $car->mileage ?? '') }}">
        @error('mileage') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Price per Day --}}
    <div class="col-md-4">
        <label for="price_per_day" class="form-label">Price / Day (KES)</label>
        <input type="number" name="price_per_day" id="price_per_day" class="form-control"
               value="{{ old('price_per_day', $car->price_per_day ?? '') }}">
        @error('price_per_day') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Image --}}
    <div class="col-12">
        <label for="image" class="form-label">Car Image</label>
        @if(isset($car) && $car->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $car->image) }}" width="150" class="rounded">
            </div>
        @endif
        <input type="file" name="image" id="image" class="form-control">
        @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

</div>
