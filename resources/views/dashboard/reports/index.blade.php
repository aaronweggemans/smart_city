@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">Check all generated reports</h4>
            <small class="mb-0">{{ Auth::user()->name }}, you can check all the generated reports here!</small><br />
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="box p-3 data-content">
            </div>
        </div>
    </div>
@endsection
