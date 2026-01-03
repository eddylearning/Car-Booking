@extends('admin.layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-4">Edit Car</h3>

    <form method="POST"
          action="{{ route('admin.cars.update', $car) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.cars.partials.form', ['car' => $car])

        <button class="btn btn-primary">
            Update Car
        </button>

        <a href="{{ route('admin.cars.index') }}"
           class="btn btn-secondary">
            Cancel
        </a>
    </form>

</div>
@endsection
