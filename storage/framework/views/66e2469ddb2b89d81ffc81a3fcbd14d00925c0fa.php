<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e(config('app.name')); ?> | Registration Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
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

                    <form action="<?php echo e(route('password.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <?php
                            if (!isset($token)) {
                                $token = \Request::route('token');
                            }
                        ?>

                        <input type="hidden" name="token" value="<?php echo e($token); ?>">

                        <div class="input-group mb-3">
                            <input type="email" name="email"
                                class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>"
                                placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                            <?php if($errors->has('email')): ?>
                                <span class="error invalid-feedback"><?php echo e($errors->first('email')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password"
                                class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>"
                                placeholder="Mot  de Passe">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                            <?php if($errors->has('password')): ?>
                                <span class="error invalid-feedback"><?php echo e($errors->first('password')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirmation Mot de passe">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                            <?php if($errors->has('password_confirmation')): ?>
                                <span
                                    class="error invalid-feedback"><?php echo e($errors->first('password_confirmation')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Réinitialisez votre mot de passe</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <p class="mt-3 mb-1">
                        <a href="<?php echo e(route('login')); ?>">Login</a>
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

</html><?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>