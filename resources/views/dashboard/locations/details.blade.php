@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">Details of {{ $city['city_name'] }}</h4>
        </div>
    </div>

    <section class="statis mt-4 text-center">
        <div class="row">
            @foreach($containers as $container)
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="box data-content p-3">
                        <a href="{{ route('dashboard_show_container', [$city['city_id'], $container['street_id']]) }}" class="text-white">
                            <i class="font-i fas fa-pen"></i>
                        </a>
                        <h3>{{ $container['street_name'] }}</h3>
                        <p class="lead">{{ $container['container_depth'] }}cm container depth</p>
                        <p class="lead">12 Linked user</p>
                    </div>
                </div>

            @endforeach
        </div>
    </section>
@endsection
