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

</head>
<body style="background-color: #fff">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-4 col-xs-12 login-banner">
            <div class="layer">
            </div>
            <div class="login-logo">
                <div>
                    <img src="{{(asset('/images/lm_logo_white.png'))}}" alt="">
                </div>
            </div>
        </div>
        <div class="col-md-8 col-xs-12 login-content">
            <div class="row pb-5">
                <div class="col-md-12 col-xs-12 text-center">
                    <img src="{{(asset('/images/ls_logo.png'))}}" alt="">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col offset-md-4">
                    <form method="POST" action="/authenticate">
                        @csrf
                        <div class="form-group mb-4">
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control hr-input" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                                {{--@if ($errors->has('error'))--}}
                                    {{--<span class="invalid-feedback">--}}
                                        {{--<strong>{{ $errors->first('error') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('error') ? ' is-invalid' : '' }} hr-input" name="password" placeholder="Password" required>

                                @if ($errors->has('error'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('error') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn hr-button btn-block rounded-btn">
                                    Login
                                </button>
                                <div class="text-center mt-2">
                                    <a href="#" class="default-color">Password reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
