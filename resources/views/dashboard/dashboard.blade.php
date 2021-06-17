@extends('layouts.dashboard')

@section('content')

    @if($percentage >= 85)
        @if($container_recommendation[0] == 'error')
            <div class="message-box" id="disappearing-message">
                <div class="card-body bg-danger text-white">
                    <h6 class="m-0">Alle vuilnisbakken in uw stad zitten vol!</h6>
                </div>
            </div>
        @else
            <div class="message-box" id="disappearing-message">
                <div class="card-body bg-warning text-white">
                    <h6 class="m-0">Uw heeft een melding!</h6>
                </div>
            </div>
        @endif
    @endif

    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">Welcome to SDI</h4>
            <small class="mb-0">Hello {{ Auth::user()->name }}!</small><br/>
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
            @if($percentage >= 85)
                @if($container_recommendation[0] != 'error')
                    <div class="box p-3 data-content mb-4">
                        <iframe
                            width="100%"
                            height="450"
                            style="border:0"
                            loading="lazy"
                            allowfullscreen
                            src="{{ $link_in_iframe }}" title="Route to the location">
                        </iframe>
                    </div>
                @else
                    <div class="box p-3 bg-danger mb-4 text-center text-white p-4">
                        <h1>Alle containers in uw stad zijn vol!</h1>
                    </div>
                @endif
            @else
                <div class="box bg-success text-white ml-3 mr-3 mb-4 p-3 text-center">
                    <h1>Container is klaar voor gebruik!</h1>
                    <br>
                    <i class="fas fa-check" style="font-size: 10em"></i>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="box p-4 data-content" style="height: 100%; text-align: center;">
                        <i class="font-i fas fa-eye text-white"></i>
                        <img src="http://localhost:8000/img/trash_bin.png" class="png-image mb-3" alt="Amount of stuff">
                        <h6 class="text-white text-center">{{ Auth::user()->getStreetName() }} has a capacity
                            of {{ $container_size }}L</h6>
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
                @if($percentage >= 85)
                    @if($container_recommendation[0] != 'error')
                        <div class="box bg-warning text-white ml-3 mr-3 mb-4 p-3">
                            <h6>Uw container zit bijna vol, neem de afval naar uw dichtstbijzijnde container die
                                beschikbaar
                                is. Deze is te vinden op
                                locatie: {{ $container_recommendation[1] . ' ' . Auth::user()->getCityName()}}</h6>
                            <br>
                            <h6>De container van {{ $container_recommendation[1] . ' ' . Auth::user()->getCityName()}}
                                zit
                                momenteel op {{ $recommended_percentage }}% ({{ $recommended_remaining }}L
                                / {{ $container_recommendation[2] }}L).
                            </h6>
                            <a href="{{ $link }}" class="text-white" target="_blank">Druk hier om
                                naar {{ $container_recommendation[1] . ' ' . Auth::user()->getCityName()}} te
                                navigeren</a>
                        </div>
                    @else
                        <div class="box bg-danger text-white ml-3 mr-3 mb-4 p-3">
                            <h6>Alle containers in uw stad zijn vol!</h6>
                            <br>
                            <h6>Als u nog afval heeft die weg gegooid moet worden, ben u genoodzaakt om een andere container
                                te gebruiken in een andere stad!</h6>
                        </div>
                    @endif

                    @else
                        <div class="box bg-success text-white ml-3 mr-3 mb-4 p-3">
                            <h6>Alles is op het moment up to date</h6>
                            <br>
                            <h6>U kunt gewoon gebruik maken van uw eigen container in de
                                wijk {{ Auth::user()->getStreetName() . ' ' . Auth::user()->getCityName()}}. Deze
                                container zit momenteel op {{ $percentage }}%.
                            </h6>
                        </div>
                    @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/maps.js') }}" defer></script>
    <script src="{{ asset('js/chart_update.js') }}" defer></script>
@endsection
