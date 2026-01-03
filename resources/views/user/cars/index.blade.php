@extends('user.layouts.user')

@section('content')
<div class="container">

    <h3 class="mb-4">Available Cars</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cars->isEmpty())
        <div class="alert alert-info">
            No cars available at the moment.
        </div>
    @else
        <div class="row">
            @foreach($cars as $car)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">

                        @if($car->image)
                            <img src="{{ asset('storage/'.$car->image) }}"
                                 class="card-img-top"
                                 style="height:200px; object-fit:cover;">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $car->name }}</h5>

                            <p class="card-text mb-1">
                                <strong>Model:</strong> {{ $car->model }}
                            </p>
                            <p class="card-text mb-1">
                                <strong>Type:</strong> {{ $car->type }}
                            </p>
                            <p class="card-text mb-1">
                                <strong>Mileage:</strong> {{ $car->mileage }} km
                            </p>

                            <p class="card-text fw-bold">
                                KES {{ number_format($car->price_per_day) }} / day
                            </p>
                        </div>

                        <div class="card-footer bg-white">
                            <a href="{{ route('user.cars.show', $car) }}"
                               class="btn btn-outline-primary w-100">
                                View & Book
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{ $cars->links() }}
    @endif

</div>
@endsection
