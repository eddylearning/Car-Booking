@extends('admin.layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-4">Add New Car</h3>

    <form method="POST"
          action="{{ route('admin.cars.store') }}"
          enctype="multipart/form-data">
        @csrf

        @include('admin.cars.partials.form')

        <button class="btn btn-primary">
            Save Car
        </button>

        <a href="{{ route('admin.cars.index') }}"
           class="btn btn-secondary">
            Cancel
        </a>
    </form>

</div>
@endsection
