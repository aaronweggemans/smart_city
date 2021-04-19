@extends('layouts.dashboard')

@section('content')
    <div class="welcome">
        <div class="content rounded-3 p-3">
            <h4 class="fs-3">{{ Auth::user()->name }}</h4>
        </div>
    </div>

    <section class="statis mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="box m-4 p-3 bg-primary text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>{{ Auth::user()->name }}</h3>
                        </div>
                        <div class="col-md-12">
                            <img src="{{ Auth::user()->getAvatarImage() }}" class="rounded-circle mb-2 image-change-placeholder"
                                 style="width: 140px;height: 125px;">
                        </div>
                    </div>
                </div>
                @error('profile_picture')
                <div class="box m-4 p-3 bg-danger text-center">
                    <small class="text-white">{{ $message }}</small>
                </div>
                @enderror
            </div>
            <div class="col-md-8">
                <div class="box m-4 p-3 data-content">
                    <h4 class="fs-3">Change profile image</h4>

                    <form name="profile_picture" action="{{ route('dashboard_update_profile_image') }}" method="post" id="change-image"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <input type="file" class="form-control-file" name="profile_picture"
                                       onchange="uploadImage(this)"
                                       id="change-image">
                            </div>
                            <div class="col-md-6">
                                <img src="{{ Auth::user()->getAvatarImage() }}" alt=""
                                     class="img-thumbnail rounded mx-auto d-block image-change-placeholder"
                                     width="100%">
                            </div>
                        </div>
                        <button class="btn btn-primary">Updated image</button>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
