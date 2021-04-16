@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">Welcome to SDI</h4>
            <small class="mb-0">Hello {{ Auth::user()->name }}!</small><br />
        </div>
    </div>

    <section class="statis mt-4 text-center">
        <div class="row">
        </div>
    </section>
@endsection
