@extends('layouts.dashboard')

@section('content')
    @if(session()->has('message'))
        <div class="alert alert-success box p-3 m-4 text-center">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">Check all full containers</h4>
            <small class="mb-0">{{ Auth::user()->name }}, here all the full containers are stored!</small><br/>
        </div>
    </div>

    <div class="row mt-4">
        @foreach($full_locations as $container)
            <div class="col-md-3 p-2">
                @if($container['status'] == true)
                    <i class="fas fa-check check-container text-success"></i>
                @else
                    <i class="fas fa-times check-container text-danger"></i>
                @endif
                <div class="box p-3 data-content text-white">
                    <h6>Container {{ $container['street_name'] }}</h6>
                    <small>Has depth of {{ $container['container_depth'] }}</small>

                    <h3 class="text-center mt-3">{{ $container['percentage'] }} %</h3>

                    @if($container['status'] == true)
                        <small>This container is used</small>
                    @else
                        <small>This container is not used</small>
                    @endif

                    <form action="{{ route("dashboard_delete_full_container", $container['street_id']) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="city_id" value="{{ $container['city_id'] }}" />
                        <input type="hidden" name="street_id" value="{{ $container['street_id'] }}" />

                        <button class="btn btn-primary" type="submit">Clean up trash bin</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
