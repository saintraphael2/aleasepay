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

<body class="hold-transition login-page opqone" style="max-height: 1000px !important;">
    <div class="login-box" >
        <!--div class="login-logo">
            <a href="{{ url('/home') }}"><b>{{ config('app.name') }}</b></a>
        </div-->
        <!-- /.login-logo -->

        <!-- /.login-box-body -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12" style="padding-bottom: 350px;">
                    <div class="card ">
                        <div class="card-header" style="text-align: center;">
                            <h4> Entrez le code de verification envoyé à votre adresse e-mail {{ $emailc }}</h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('validationOtp') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-4" style="text-align: right;">
                                        <label for="email" class="text-md-end">CODE</label>

                                    </div>
                                    <div class="col-8">
                                        <input id="otp" type="text"
                                            class="form-control @error('otp') is-invalid @enderror" name="otp"
                                            value="{{ old('otp') }}" required>
                                        <input id="email" type="hidden"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $email }}" required>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 14px;margin-left: -8px;">
                                    <div class="col-4">
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary">
                                            Valider
                                        </button>
                                    </div>
                                    <div class="col-3">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>

    </div>
    <!-- /.login-box -->

    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>