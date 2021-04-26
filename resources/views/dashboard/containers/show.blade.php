@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">Container {{ $container['street_name'] }}</h4>
            <small class="mb-0">Linked in {{ $city['city_name'] }}!</small><br/>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            @if(session()->has('message'))
                <div class="alert alert-success box p-3 m-4 text-center">
                    {{ session()->get('message') }}
                </div>
            @endif

            <div class="box bg-secondary p-3 mb-3 text-white text-center">
                <i class="font-i fas fa-trash"></i>
                <h3>
                    {{ $container['container_depth'] }}</h3>
                <p class="lead">Container depth</p>
            </div>

            <div class="box bg-primary p-3 mb-3 text-white text-center">
                <i class="font-i fas fa-trash"></i>
                <h3>Location</h3>
                <p class="lead">{{ $container['latitude'] }} & {{ $container['longitude'] }}</p>
            </div>

            <div class="box bg-danger p-3 mb-3 text-white text-center">
                <i class="font-i fas fa-trash"></i>
                <h3>
                    {{ $container['container_depth'] }}</h3>
                <p class="lead">Amount of linked users</p>
            </div>

            <div class="box bg-success p-3 mb-3 text-white text-center">
                <i class="font-i fas fa-trash"></i>
                <h3>
                    {{ $container['container_depth'] }}</h3>
                <p class="lead">Amount of usages</p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box p-3 data-content mb-4 text-white">
                <h4 class="fs-3">City {{ $city['city_name'] }}</h4>
                <p>Linked container {{ $container['street_name'] }}</p>


                <form action="{{ route('dashboard_delete_container', [$city['city_id'], $container['street_id']]) }}"
                      method="post">
                    @csrf
                    @method('delete')

                    <button class="btn btn-danger" type="submit" style="position: absolute; top: 15px; right: 15px">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>

                <form action="{{ route('dashboard_update_container', [$city['city_id'], $container['street_id']]) }}"
                      method="post">
                    @csrf
                    <input type="hidden" name="city_id" value="{{ $city['city_id'] }}" />
                    <input type="hidden" name="street_id" value="{{ $container['street_id'] }}" />

                    <div class="row">
                        <div class="col-md-2">
                            Street name:
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="street_name" class="form-control mb-3" value="{{ $container['street_name'] }}"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            Container Depth:
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="container_depth" class="form-control mb-3" value="{{ $container['container_depth'] }}"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            Latitude:
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="latitude" class="form-control mb-3" value="{{ $container['latitude'] }}"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            Longitude:
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="longitude" class="form-control mb-3" value="{{ $container['longitude'] }}"/>
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Update container settings</button>
                </form>
            </div>
        </div>
    </div>
@endsection
