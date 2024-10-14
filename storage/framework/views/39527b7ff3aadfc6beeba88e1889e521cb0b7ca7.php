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

<body class="hold-transition register-page opqone" style="max-height: 1000px !important;">
    <div style="width: 700px; !important; ">
        <div class="row justify-content-center">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Mot Passe Perdu
                </p>
                <div class="card-header">Réinitialise ton mot de passe</div>
                <div class="card-body">
                    <?php if(Session::has('message')): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo e(Session::get('message')); ?>

                    </div>
                    <?php endif; ?>
                    <form action="<?php echo e(route('reset.password.post')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="token" value="<?php echo e($token); ?>">
                        <div class="form-group row ">
                            <label for="email" class="col-md-6 col-form-label text-md-right">E-Mail
                            </label>
                            <div class="col-md-6">
                                <input type="email" name="email"
                                    class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>"
                                    placeholder="Email">
                                <?php if($errors->has('email')): ?>
                                <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-6 col-form-label text-md-right">Nouveau mot de
                                passe</label>
                            <div class="col-md-6">
                                <input type="password" name="password"
                                    class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>"
                                    placeholder="Mot  de Passe">
                                <?php if($errors->has('password')): ?>
                                <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-6 col-form-label text-md-right">Confirmation Mot
                                de passe
                            </label>
                            <div class="col-md-6">
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Confirmation Mot de passe">

                                <?php if($errors->has('password_confirmation')): ?>
                                <span class="text-danger"><?php echo e($errors->first('password_confirmation')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Modifier
                            </button>
                        </div>
                    </form>
                    <?php if($errors->any()): ?>
                    <div>
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <p class="mt-3 mb-1">
                        <a href="<?php echo e(route('login')); ?>">Connexion</a>
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

</html><?php /**PATH C:\Users\kokou.djimissa\Documents\Projets\altprojects\aleasepay\resources\views/auth/forgetPasswordLink.blade.php ENDPATH**/ ?>