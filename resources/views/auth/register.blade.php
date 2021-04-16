@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="login100-form validate-form">
        @csrf
        <span class="login100-form-title">
            Regiser your account
        </span>

        <div class="wrap-input100 validate-input" data-validate="Valid name is required">
            <input
                id="name"
                type="text"
                class="input100"
                name="name"
                value="{{ old('name') }}"
                required
                autocomplete="name"
                placeholder="Please enter a name">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fas fa-user" aria-hidden="true"></i>
            </span>
        </div>

        @error('name')
        <small class="text-danger">{{ $message }}</small>
        @enderror

        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
            <input
                id="email"
                type="email"
                class="input100"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                placeholder="Pleae enter your email">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
        </div>

        @error('email')
        <small class="text-danger">{{ $message }}</small>
        @enderror


        <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input
                id="password"
                type="password"
                class="input100"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
        </div>

        @error('password')
        <small class="text-danger">{{ $message }}</small>
        @enderror


        <div class="wrap-input100 validate-input" data-validate="You need to confirm you password">
            <input
                id="password-confirm"
                type="password"
                class="input100"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Confirm your password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
        </div>

        @error('password_confirmation')
        <small class="text-danger">{{ $message }}</small>
        @enderror

        <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn">
                {{ __('Register') }}
            </button>
        </div>

        <div class="text-center p-t-136">
            <a class="txt2" href="{{ route('login') }}">
                Want to login?
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
        </div>
@endsection
