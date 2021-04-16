@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">{{ Auth::user()->name }}</h4>
            <small class="mb-0">U zit gelinkt aan locatie Landstrekenwijk Lelystad</small>
        </div>
    </div>

    <section class="statis mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="box bg-success m-4 p-3 text-center text-white">
                    <div class="text-white">
                        <a href="{{ route('dashboard_add_location') }}" class="text-white" style="position: absolute; top: 7.5px; right: 7.5px">
                            <i class="fas fa-plus fa-lg"></i>
                        </a>
                    </div>
                    <h3>Locations</h3>
                    <p class="lead m-0 p-0">
                        3
                    </p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box m-4 p-3 data-content">
                    <h4 class="fs-3">Settings</h4>

                    <p>This user is linked to location: Landstrekenwijk Lelystad</p>
                </div>
            </div>
        </div>
    </section>
@endsection
