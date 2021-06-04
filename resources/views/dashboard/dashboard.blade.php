@extends('layouts.dashboard')

@section('content')

    @if($percentage >= 70)
        <div class="card mb-4">
            <div class="card-body bg-warning text-white">
                <h4>Container zit al redelijk vol, ga naar {{ $container_recommendation[0] . ' ' . Auth::user()->getCityName()}}</h4>
            </div>
        </div>
    @endif

    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">Welcome to SDI</h4>
            <small class="mb-0">Hello {{ Auth::user()->name }}!</small><br />
        </div>
    </div>

    <section class="statis mt-4 text-center">
        <div class="row">
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <div class="box bg-primary p-3">
                    <i class="font-i fas fa-eye"></i>
                    <h3>{{ $today }}</h3>
                    <p class="lead">Today's Date</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <div class="box bg-danger p-3">
                    <i class="font-i fas fa-users"></i>
                    <h3>{{ $all_users }}</h3>
                    <p class="lead">User registered</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                <div class="box bg-warning p-3">
                    <i class="font-i fas fa-trash"></i>
                    <h3>5,154</h3>
                    <p class="lead">Kilo afval</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="box bg-success p-3">
                    <i class="font-i fas fa-location-arrow"></i>
                    <h3>{{ $all_registered_containers }}</h3>
                    <p class="lead">All containers</p>
                </div>
            </div>
        </div>
    </section>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="box p-3 data-content mb-4">
                <canvas id="container_distance_chart"></canvas>
            </div>
            <div class="box p-3 data-content mb-4">
                <canvas id="garbage_all_chart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="box p-4 data-content" style="height: 100%; text-align: center;">
                        <i class="font-i fas fa-eye text-white"></i>
                        <img src="http://localhost:8000/img/trash_bin.png" class="png-image mb-3" alt="Amount of stuff">
                        <h6 class="text-white text-center">{{ Auth::user()->getStreetName() }} has a capacity of {{ $container_size }}cm</h6>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box p-4 data-content" style="text-align: center;">
                        <i class="font-i fas fa-eye text-white"></i>

                        <svg class="circle-chart text-white" viewbox="0 0 33.83098862 33.83098862" width="200"
                             height="200"
                             xmlns="http://www.w3.org/2000/svg">
                            <circle class="circle-chart__background" stroke="#efefef" stroke-width="2"
                                    fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431"/>
                            <circle class="circle-chart__circle" id="stroke-dasharray" stroke="#DC3545" stroke-width="2"
                                    stroke-dasharray="{{ $percentage }},100" stroke-linecap="round" fill="none"
                                    cx="16.91549431" cy="16.91549431" r="15.91549431"/>
                            <h1 class="text-white center-doughnut" id="doughnut-percentage-text">{{ $percentage }}%</h1>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="box ml-3 mr-3 mb-4" style="width: 100%; height: 400px">
                    <div id="chart_div"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/maps.js') }}" defer></script>
    <script src="{{ asset('js/chart_update.js') }}" defer></script>
@endsection
