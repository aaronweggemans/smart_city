@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">{{ Auth::user()->name }}</h4>
            <small class="mb-0">U zit gelinkt
                aan {{ Auth::user()->getStreetName() }} {{ Auth::user()->getCityName() }}</small>
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
                            <a class="btn btn-secondary" href="{{ route('dashboard_change_profile') }}">Change profile
                                picture</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box m-4 p-3 data-content">
                    <h4 class="fs-3">Location settings</h4>
                    <p>This user is linked to
                        location: {{ Auth::user()->getStreetName() }} {{ Auth::user()->getCityName() }}</p>

                    <form action="{{ route('dashboard_update_profile_location') }}" method="post">
                        @csrf

                        <select name="city" class="form-control mb-3" onchange="getStreetData(this)">
                            @foreach($cities as $city)
                                <option value="{{ $city['city_id'] }}"
                                        @if($city['city_id'] == Auth::user()->city_id) selected @endif>
                                    {{ $city['city_name'] }}
                                </option>
                            @endforeach
                        </select>

                        <select name="street" class="form-control mb-3" id="append_streets">
                            @foreach($streets as $street)
                                <option value="{{ $street['street_id'] }}"
                                        @if($street['street_id'] == Auth::user()->street_id) selected @endif>
                                    {{ $street['street_name'] }}</option>
                            @endforeach
                        </select>

                        <button class="btn btn-primary">Change location</button>
                    </form>
                </div>
                <div class="box m-4 p-3 data-content">
                    <h4 class="fs-3">Account settings</h4>

                    <form action="{{ route('dashboard_update_user', Auth::user()->id) }}" method="post">
                        @csrf

                        <input type="text" name="name" class="form-control mb-3" value="{{ Auth::user()->name }}">
                        <input type="text" name="email" class="form-control mb-3" value="{{ Auth::user()->email }}">

                        <button class="btn btn-primary" type="submit">Update user</button>
                    </form>

                    <form action="{{ route('dashboard_delete_user') }}" method="post">
                        @csrf
                        @method('delete')

                        <button class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
