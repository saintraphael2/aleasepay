<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Registration Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
    .step {
        display: none;
    }

    .active {
        display: block;
    }
    </style>
</head>

<body class="hold-transition register-page opqone" style="height: 840px !important;padding-bottom: 153px;">
    <div style="width: 700px; !important; ">
        <div class="row justify-content-center">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Mot Passe Perdu
                </p>
                <div class="card-header">Réinitialise ton mot de passe</div>
                <div class="card-body">
                    @if (Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('message') }}
                    </div>
                    @endif
                    <form action="{{ route('forget.password.post') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                            <div class="col-md-6">
                                <input type="text" id="email_address" class="form-control" name="email" required
                                    autofocus>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                               Valider
                            </button>
                        </div>
                    </form>
                    <p class="mt-3 mb-1">
                        <a href="{{ route('login') }}">Connexion</a>
                    </p>
                </div>
            </div>
        </div>


        <!-- /.form-box -->
    </div>
    <!-- /.register-box -->

    <script>

    </script>
</body>

</html>