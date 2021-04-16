@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="login100-form validate-form">
        @csrf
        <span class="login100-form-title">
            Please login
        </span>

        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
            <input id="email" type="email"
                   class="input100" name="email"
                   value="{{ old('email') }}" required placeholder="Please enter your email" autocomplete="email">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
        </div>

        <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input id="password" type="password"
                   class="input100" name="password"
                   required placeholder="Please enter your password" autocomplete="current-password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
        </div>

        @error('email')
        <small class="text-danger">{{ $message }}</small>
        @enderror

        @error('password')
        <small class="text-danger">{{ $message }}</small>
        @enderror

        <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn">
                {{ __('Login') }}
            </button>
        </div>

        @if (Route::has('password.request'))
            <div class="text-center p-t-12">
                <a class="txt2" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            </div>
        @endif

        <div class="text-center p-t-136">
            <a class="txt2" href="{{ route('register') }}">
                Create your Account
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
        </div>
    </form>
@endsection
