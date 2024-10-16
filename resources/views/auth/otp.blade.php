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

<body class="hold-transition login-page opqone" style="height: 840px !important;padding-bottom: 153px;">
    <div class="row loginbodybackg">
        <div class="logincustomize loginblocktwo">
            <div class="login-box">
                <div class="card logincardctz">
                    <div class="card-body login-card-body">
                        <!--p class="login-box-msg">{{ __('auth.login.title') }}</p-->
                        <div class="">
                            <h5 class="login-box-msg" style="color:black !important;">Entrez le code de verification
                                envoyé à votre adresse e-mail: {{ $emailc }}</h5>
                        </div>

                        <form method="post" action="{{ route('validationOtp') }}">
                            @csrf
                            <div class="row">
                                <div class="input-group mb-3">

                                    <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror"
                                        name="otp" value="{{ old('otp') }}" required>
                                    <input id="email" type="hidden"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email }}" required>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary btn-block submit-color">Valider</button>
                                </div>
                            </div>
                        </form>


                        <!--form method="POST" action="{{ route('validationOtp') }}">

                            <div class="row">
                                <div class="col-4" style="text-align: right;">
                                    <label for="email" class="text-md-end">CODE</label>
                                </div>
                                <div class="col-8">
                                    <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror"
                                        name="otp" value="{{ old('otp') }}" required>
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
                        </form-->

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