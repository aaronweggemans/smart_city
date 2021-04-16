@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="login100-form validate-form">
        @csrf
        <span class="login100-form-title">
            Forgot your password?
        </span>

        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
            <input id="email" type="email" class="input100" name="email"
                   value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
        </div>

        @error('email')
        <small class="text-danger">{{ $message }}</small>
        @endif

        <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>

        <div class="text-center p-t-136">
            <a class="txt2" href="{{ route('login') }}">
                Go back to login
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
        </div>
    </form>
@endsection
