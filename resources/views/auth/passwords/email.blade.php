<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("css/custom.css")}}">

    <link rel="stylesheet" href="{{asset("css/theme.css")}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg">
    @if (session('message'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "{{ session('message') }}",
            icon: "{{ session('alert-type') }}",
            confirmButtonColor: "#20b8f1"
        }).then(function() {
            window.location.href = "/login";
        });;
    </script>
    @endif
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-6 col-xs-12 fp-banner-mobile">
            <div>
                <img style="transform: scale(80%) rotate(-30deg)" src="{{(asset('/images/banner_image.png'))}}" alt="">
            </div>
        </div>
        <div class="col-md-6 col-xs-12 login-content">
            <div class="row pb-4">
                <div class="col-md-12 col-xs-12 mb-2 text-center">
                    <picture>
                        <source media="(max-width: 768px)" srcset="{{(asset('/images/ls_logo_mobile.png'))}}">
                        <img class="ls-logo" src="{{(asset('/images/ls_logo.png'))}}" alt="">
                    </picture>
                </div>
                <div class="col-md-12 col-xs-12 text-center tiny-text">
                    <p>Please enter your username or <br>
                        email address:</p>
                </div>

            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-12 offset-md-6">
                        <form method="POST" action="#">
                            @csrf

                            <div class="form-group mb-4">
                                <div class="col-md-6">
                                    <label for="email" class="form-top-text mb-2">Email</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <div class="col-md-6">
                                    <button type="submit" class="btn hr-button btn-block rounded-btn login-btn">
                                        Reset
                                    </button>
                                    <div class="text-center mt-2">
                                        <a href="/login" class="tiny-text">Back to login page</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 fp-banner">
            <div>
                <img style="transform: scale(80%) rotate(-30deg)" src="{{(asset('/images/banner_image.png'))}}" alt="">
            </div>
        </div>
    </div>
    </div>
</body>