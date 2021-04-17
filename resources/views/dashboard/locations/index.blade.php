@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="fs-3">Location insights</h4>
                    <small class="mb-0">Here the administrator can do the location management!</small>
                </div>
                <div class="col-md-4">
                    <div class="float-sm-right">
                        {{ $locations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="statis mt-4 text-center">
        <div class="row">
            <div class="col-md-6">
                <div class="box data-content p-4" style="width: 100%; height: 100%">
                    <div id="chart_div" style="height: 100% !important; color: black !important"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box data-content p-4">
                    @foreach($locations as $location)

                        <div class="row text-white p-1">
                            <div class="col-md-2 text-center">
                                <i class="fas fa-location-arrow"></i>
                            </div>
                            <div class="col-md-6">
                                <a class="user-details"
                                   href="{{ route('dashboard_location_details', $location['city_name']) }}">{{ $location['city_name'] }}</a>
                            </div>
                            <div class="col-md-4">
                                @foreach($location['containers'] as $container)
                                    <p>{{ $container['street_name'] }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
