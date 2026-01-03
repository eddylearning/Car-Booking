@extends('admin.layouts.admin')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Cars</h3>
        <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">
            + Add Car
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cars->isEmpty())
        <div class="alert alert-info">
            No cars available.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Mileage</th>
                        <th>Price / Day</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cars as $car)
                        <tr>
                            <td>
                                @if($car->image)
                                    <img src="{{ asset('storage/'.$car->image) }}"
                                         width="80"
                                         class="rounded">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $car->name }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->type }}</td>
                            <td>{{ $car->mileage }}</td>
                            <td>KES {{ number_format($car->price_per_day) }}</td>
                            <td>
                                <a href="{{ route('admin.cars.edit', $car) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('admin.cars.destroy', $car) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this car?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $cars->links() }}
    @endif

</div>
@endsection
