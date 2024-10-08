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

<body class="hold-transition register-page opqone"  style="max-height: 1000px !important;" >
    <div style="width: 700px; !important; ">
        <div class="row justify-content-center">
        <div class="card-body login-card-body">
                    <p class="login-box-msg">Mot Passe Perdu
                       </p>

                       <div class="card-header">Reset Password</div>

<div class="card-body">



  @if (Session::has('message'))

       <div class="alert alert-success" role="alert">

          {{ Session::get('message') }}

      </div>

  @endif



  <form action="{{ route('reset.password.post') }}" method="POST">

@csrf

<input type="hidden" name="token" value="{{ $token }}">



<div class="form-group row">

    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

    <div class="col-md-6">

        <input type="text" id="email_address" class="form-control" name="email" required autofocus>

        @if ($errors->has('email'))

            <span class="text-danger">{{ $errors->first('email') }}</span>

        @endif

    </div>

</div>



<div class="form-group row">

    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

    <div class="col-md-6">

        <input type="password" id="password" class="form-control" name="password" required autofocus>

        @if ($errors->has('password'))

            <span class="text-danger">{{ $errors->first('password') }}</span>

        @endif

    </div>

</div>



<div class="form-group row">

    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

    <div class="col-md-6">

        <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>

        @if ($errors->has('password_confirmation'))

            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>

        @endif

    </div>

</div>



<div class="col-md-6 offset-md-4">

    <button type="submit" class="btn btn-primary">

        Reset Password

    </button>

</div>

</form>
                    <p class="mt-3 mb-1">
                        <a href="{{ route('login') }}">Login</a>
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