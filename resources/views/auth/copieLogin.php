<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body class="hold-transition login-page">
    <div class="row">
        <div class="col-6 logincustomize" >
            <div class="" >
                
            </div>
        </div>
        <div class="col-6 logincustomize" >
            <div class="login-box">
                <div class="login-logo">
                    <a href="#"><b>{{ config('app.name') }}</b></a>
                </div>
                <!-- /.login-logo -->

                <!-- /.login-box-body -->
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">{{ __('auth.login.title') }}</p>

                        <form method="post" action="{{ url('/login') }}">
                            @csrf

                            <div class="input-group mb-3">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                                    class="form-control @error('email') is-invalid @enderror">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                                </div>
                                @error('email')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <input type="password" name="password" placeholder="Password"
                                    class="form-control @error('password') is-invalid @enderror">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">{{ __('auth.remember_me') }}</label>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <button type="submit"
                                        class="btn btn-primary btn-block">{{ __('auth.sign_in') }}</button>
                                </div>

                            </div>
                        </form>

                        <p class="mb-1">
                            <a href="{{ route('password.request') }}">{{ __('auth.login.forgot_password') }}</a>
                        </p>
                        <p class="mb-0">
                            <a href="{{ route('register') }}"
                                class="text-center">{{ __('auth.login.register_membership') }}</a>
                        </p>
                    </div>
                    <!-- /.login-card-body -->


                </div>

            </div>
        </div>
    </div>

    <!-- /.login-box -->

    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>