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

<body class="hold-transition register-page opqone" style="max-height: 1000px !important;">
    <div style="width: 700px; !important; ">
        <div class="row justify-content-center">
<<<<<<< HEAD
            <div class="card-body login-card-body">
                <p class="login-box-msg"> Mot de Passe Perdu </p>

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    @php
                    if (!isset($token)) {
                    $token = \Request::route('token');
                    }
                    @endphp

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="input-group mb-3">
                        <input type="email" name="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
=======
        <div class="card-body login-card-body">
                    <p class="login-box-msg">Mot de Passe Perdu
                       </p>

                       <form action="{{ route('update-password') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="oldPasswordInput" class="form-label">Old Password</label>
                                <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                    placeholder="Old Password">
                                @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="newPasswordInput" class="form-label">New Password</label>
                                <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                    placeholder="New Password">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                                <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput"
                                    placeholder="Confirm New Password">
                            </div>

>>>>>>> fd061041af6b9fe6cca4af8789f103c6e58086c6
                        </div>
                        @if ($errors->has('email'))
                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

<<<<<<< HEAD
                    <div class="input-group mb-3">
                        <input type="password" name="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            placeholder="Mot  de Passe">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
=======
                        <div class="card-footer">
                            <button class="btn btn-success">Submit</button>
>>>>>>> fd061041af6b9fe6cca4af8789f103c6e58086c6
                        </div>
                        @if ($errors->has('password'))
                        <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

<<<<<<< HEAD
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirmation Mot de passe">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                        @if ($errors->has('password_confirmation'))
                        <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Réinitialisez votre mot de
                                passe</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
=======
                    </form>
                    <p class="mt-3 mb-1">
                        <a href="{{ route('login') }}">Login</a>
                    </p>
                   
>>>>>>> fd061041af6b9fe6cca4af8789f103c6e58086c6
                </div>
                @endif
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