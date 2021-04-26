@extends('layouts.auth')

@section('content')
    <div class="login100-form validate-form">
        <span class="login100-form-title">
            Oh, Oh, Page not found!
        </span>

        <div class="wrap-input100 validate-input text-center">
            We are sorry, the page you requested could not be found! Please go back to the homepage or contact us at
            <a href="mailto:administration@sdi.com">administration@sdi.com</a>
        </div>

        <div class="container-login100-form-btn">
            <a href="{{ route('landing_page') }}">Go back</a>
        </div>

        <div class="text-center p-t-136">
            <a class="txt2" href="{{ route('register') }}">
                Create a new account
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
        </div>
    </div>
@endsection
