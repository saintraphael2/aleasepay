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
    <link type="text/css" rel="stylesheet" href="{{ asset('css/waitMe.css') }}">

</head>

<body class="hold-transition login-page loginbodybackg" style="height: 840px !important;padding-bottom: 153px;">
    <div class="row loginbodybackg">
        <div class=" logincustomize loginblockone">
            <div class="">
                <img class="imgctz" src="../images/logoalt.png" />
            </div>
        </div>
        <div class="logincustomize loginblocktwo" style="">
            <div class="login-box">
                <!--div class="login-logo">
                    <a href="#"><b>{{ config('app.name') }}</b></a>
                </div-->
                <!-- /.login-logo -->
                <!-- /.login-box-body -->
                <div class="card logincardctz containerBlock">
                    <div class="card-body login-card-body">
                        <!--p class="login-box-msg">{{ __('auth.login.title') }}</p-->
                        <section id="loading">
                            <div id="loading-content"></div>
                        </section>
                        <div class="iconlogin">
                            <h4 class="login-box-msg" style="color:black !important;">Bienvenue sur votre banque en
                                ligne</h4>
                            <i class="fas fa-user"></i>
                        </div>
                        @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                        @endif
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
                                <!--div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">{{ __('auth.remember_me') }}</label>
                                    </div>
                                </div-->
                                <div class="col-12">
                                    <button type="submit" id="waitMe_ex"
                                        class="btn btn-primary btn-block submit-color">Connexion</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <a href="{{ route('forget.password.get') }}">
                                        <div class="col-12 iconlogin">
                                            <i class="fas fa fa-key"></i>
                                        </div>
                                        <div class="col-12">
                                            <span style="font-size: 15px;">Mot de passe oublié?</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-5">
                                    <a href="{{ route('register') }}" class="text-center">
                                        <div class="col-12 iconlogin">
                                            <i class="fas fa fa-plus-circle"></i>
                                        </div>
                                        <div class="col-12">

                                            <span style="font-size: 15px;">S'enregistrer
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.login-box -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('js/waitMe.js') }}"></script>

    <script>
    function showLoading() {
        document.querySelector('#loading').classList.add('loading');
        document.querySelector('#loading-content').classList.add('loading-content');
    }

    function hideLoading() {
        document.querySelector('#loading').classList.remove('loading');
        document.querySelector('#loading-content').classList.remove('loading-content');
    }


    document.getElementById("waitMe_ex").addEventListener("click", function(event) {
        // Empêche le formulaire de se soumettre automatiquement
        event.preventDefault();

        // Action que tu veux exécuter au clic
        
        showLoading();

        // Tu peux aussi soumettre manuellement le formulaire si nécessaire
        document.getElementById("myForm").submit();
        hideLoading();
    });
    </script>
</body>

</html>