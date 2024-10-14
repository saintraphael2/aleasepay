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
    <style>
    .error-container {
        text-align: center;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .error-title {
        font-size: 2rem;
        color: #dc3545;
    }

    .error-message {
        margin-top: 10px;
        font-size: 1.2rem;
    }

    .btn-home {
        margin-top: 20px;
    }
    </style>
</head>

<body class="hold-transition login-page opqone" style="max-height: 1000px !important;">
    <div class="row loginbodybackg">
        <div class="logincustomize loginblocktwo">
            <div class="login-box">
                <div class="card logincardctz">
                    <div class="card-body login-card-body">
                        <div class="error-container">
                            <h1 class="error-title">Erreur</h1>
                            <p class="error-message">
                                @if(session('error'))
                                {{ session('error') }}
                                @else
                                Une erreur est survenue. Veuillez réessayer plus tard.
                                @endif
                            </p>
                            <a href="{{ url('/') }}" class="btn btn-primary btn-home">Retour à la page d'accueil</a>
                        </div>
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