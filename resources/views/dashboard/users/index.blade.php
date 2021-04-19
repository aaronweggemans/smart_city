@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="fs-3">Insights for all users</h4>
                    <small class="mb-0">{{ Auth::user()->name }}, you can do your user management here!</small>
                </div>
                <div class="col-md-4">
                    <div class="float-sm-right">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @if(session()->has('message'))
                    <div class="alert alert-success box p-3 m-4 text-center">
                        {{ session()->get('message') }}
                    </div>
            @endif

            <div class="box bg-primary m-4 p-3 text-center text-white">
                <i class="font-i fas fa-users"></i>
                <h3>{{$amount_of_users}}</h3>
                <p class="lead">User registered</p>
            </div>
            <div class="box bg-danger m-4 p-3 text-center text-white">
                <i class="uil-user font-i"></i>
                <h3>{{ $amount_of_administrators }}</h3>
                <p class="lead">Administrators registered</p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box m-4 p-3 data-content">
                @foreach($users as $user)
                    <div class="row text-white p-2">
                        <div class="col-md-1 text-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="col-md-3">
                            <a class="user-details"
                               href="{{ route('dashboard_show_user', $user->id) }}">{{ $user->name }}</a>
                        </div>
                        <div class="col-md-2">
                            {{ $user->getCityName() }}
                        </div>
                        <div class="col-md-2">
                            {{ $user->getRoleName() }}
                        </div>
                        <div class="col-md-4">{{ $user->email }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection
