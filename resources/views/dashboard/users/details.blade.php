@extends('layouts.dashboard')

@section('content')
    <div class="welcome mb-2">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">Details for {{ $user->name }}</h4>
            <small class="mb-0">This user is created at: {{ $user->created_at }}!</small><br/>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-6">
            <div class="box p-4 mb-4 data-content">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <img src="{{ $user->avatar }}" class="rounded-circle mb-3"
                             style="width: 150px;height: 125px;">
                        <h6 class="text-white">This user is assigned as a {{ $user->getRoleName() }}</h6>
                    </div>
                    <div class="col-md-6 text-white">
                        <h6 class="mb-3">{{ $user->name }}</h6>
                        <h6 class="mb-3">{{ $user->email }}</h6>

                        <form action="{{ route('dashboard_remove_user', $user->id) }}" method="post">
                            @csrf
                            @method('delete')

                            <button class="btn btn-danger" type="submit">Delete this user</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="box bg-success p-3 text-white text-center">
                        <i class="font-i fas fa-location-arrow"></i>
                        <h3>Uses trash bin</h3>
                        <p class="lead">Relationship not setted</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box bg-warning p-3 text-center text-white">
                        <i class="font-i fas fa-trash"></i>
                        <h3>Trash removed</h3>
                        <p class="lead">Nog wat</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <form action="{{ route('dashboard_update_user', $user->id) }}" method="post">
                @csrf

                <div class="box p-4 data-content mb-4">
                    <h4 class="fs-3 text-white mb-3">Permission for this user</h4>
                    <div class="row text-white">
                        <div class="col-md-4 my-auto">
                            <h6>User role</h6>
                        </div>
                        <div class="col-md-8">
                            {{-- TODO: THIS CAN BE AN AJAX CALL --}}
                            <select name="permission" id="permission" class="form-control @error('permission') is-invalid @enderror">
                                @foreach($roles as $role)
                                    <option
                                        value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box p-4 data-content">
                    <h4 class="fs-3 text-white mb-3">Change user details</h4>
                    <div class="row text-white mb-2">
                        <div class="col-md-4 my-auto">
                            <h6 class="align-middle">First- & Lastname</h6>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}">
                        </div>
                    </div>
                    <div class="row text-white">
                        <div class="col-md-4 my-auto">
                            <h6 class="align-middle">Email Address</h6>
                        </div>
                        <div class="col-md-8">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Update details</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
