@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">{{ Auth::user()->name }}</h4>
            <small class="mb-0">U zit gelinkt aan {{ Auth::user()->getStreetName() }} {{ Auth::user()->getCityName() }}</small>
        </div>
    </div>

    <section class="statis mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="box bg-success m-4 p-3 text-center text-white">
                    <div class="text-white">
                        <a href="{{ route('dashboard_add_location') }}" class="text-white"
                           style="position: absolute; top: 7.5px; right: 7.5px">
                            <i class="fas fa-plus fa-lg"></i>
                        </a>
                    </div>
                    <h3>Locations</h3>
                    <p class="lead m-0 p-0">
                        3
                    </p>
                </div>
                <div class="box m-4 p-3 bg-primary text-center">

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Account image</h3>
                        </div>
                        <div class="col-md-12">
                            <img src="{{ Auth::user()->getAvatarImage() }}" class="rounded-circle mb-2"
                                 style="width: 140px;height: 125px;">
                        </div>
                        <div class="col-md-12">
                            <a class="btn btn-secondary" href="{{ route('dashboard_change_profile') }}">Change profile picture</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box m-4 p-3 data-content">
                    <h4 class="fs-3">Location settings</h4>
                    <p>This user is linked to location: Landstrekenwijk Lelystad</p>

                    <select class="form-control mb-3" onchange="getStreetData(this)">
                        @foreach($cities as $city)
                            <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                        @endforeach
                    </select>

                    <select name="" class="form-control" id="append_streets">
                        <option value=""></option>
                    </select>
                </div>
                <div class="box m-4 p-3 data-content">
                    <h4 class="fs-3">Account settings</h4>

                    <form action="" method="post">
                        <input type="text">
                    </form>
                    <p>This user is linked to location: Landstrekenwijk Lelystad</p>
                </div>
            </div>
        </div>
    </section>
@endsection
