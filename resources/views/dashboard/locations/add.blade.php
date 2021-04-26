@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">Add new location</h4>
            <small class="mb-0">You can add here a new location</small><br/>
        </div>
    </div>

    <section class="statis mt-4">
        <div class="row">
            <div class="col-md-4">
                @if(session()->has('message'))
                    <div class="alert alert-success box p-3 m-4 text-center">
                        {{ session()->get('message') }}
                    </div>
                @endif

                <div class="box bg-success m-4 p-3 text-center text-white">
                    <div class="text-white">
                        <a href="{{ route('dashboard_add_location') }}" class="text-white"
                           style="position: absolute; top: 7.5px; right: 7.5px">
                            <i class="fas fa-plus fa-lg"></i>
                        </a>
                    </div>
                    <h3>Locations</h3>
                    <p class="lead m-0 p-0">
                        Yoyo yoghurt
                        moet je ontdekken
                    </p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box m-4 p-3 data-content">
                    <h4 class="fs-3">Add new location</h4>

                    <form action="{{ route('dashboard_create_location') }}" method="post">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-2 my-auto">
                                <h6 class="align-middle">City Name</h6>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="city_name" placeholder="Amsterdam">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Add Container's</h4>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2 my-auto">
                                <h6 class="align-middle">Street Name</h6>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="street_name" placeholder="Hermanlaan">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2 my-auto">
                                <h6 class="align-middle">Latitude</h6>
                            </div>
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="latitude" placeholder="52...">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2 my-auto">
                                <h6 class="align-middle">Longitude</h6>
                            </div>
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="longitude" placeholder="4...">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2 my-auto">
                                <h6 class="align-middle">Container size</h6>
                            </div>
                            <div class="col-md-10">
                                <input type="number" class="form-control" name="container_depth" placeholder="100">
                            </div>
                        </div>


                        <button class="btn btn-primary">Add location</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
