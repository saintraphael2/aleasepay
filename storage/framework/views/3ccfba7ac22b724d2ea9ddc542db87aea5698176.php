<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e(config('app.name')); ?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('css/waitMe.css')); ?>">

</head>

<body class="hold-transition login-page loginbodybackg" style="height: 840px !important;padding-bottom: 153px;">

    <div class="row loginbodybackg">
        <section id="loading">
            <div id="loading-content"></div>
        </section>
        <div class=" logincustomize loginblockone">
            <div class="">
                <img class="imgctz" src="../images/logoalt.png" />
            </div>
        </div>
        <div class="logincustomize loginblocktwo" style="">
            <div class="login-box">
                <!--div class="login-logo">
                    <a href="#"><b><?php echo e(config('app.name')); ?></b></a>
                </div-->
                <!-- /.login-logo -->
                <!-- /.login-box-body -->
                <div class="card logincardctz containerBlock">
                    <div class="card-body login-card-body">
                        <!--p class="login-box-msg"><?php echo e(__('auth.login.title')); ?></p-->

                        <div class="iconlogin">
                            <h4 class="login-box-msg" style="color:black !important;">Bienvenue sur votre banque en
                                ligne</h4>
                            <i class="fas fa-user"></i>
                        </div>
                        <?php if(Session::has('message')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(Session::get('message')); ?>

                        </div>
                        <?php endif; ?>
                        <form method="post" action="<?php echo e(url('/login')); ?>" id="loginform">
                            <?php echo csrf_field(); ?>

                            <div class="input-group mb-3">
                                <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email"
                                    class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="input-group mb-3">
                                <input type="password" name="password" placeholder="Password"
                                    class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="row">
                                <!--div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember"><?php echo e(__('auth.remember_me')); ?></label>
                                    </div>
                                </div-->
                                <div class="col-12">
                                    <button type="submit" id="waitMe_ex"
                                        class="btn btn-primary btn-block submit-color">Connexion</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <a href="<?php echo e(route('forget.password.get')); ?>">
                                        <div class="col-12 iconlogin">
                                            <i class="fas fa fa-key"></i>
                                        </div>
                                        <div class="col-12">
                                            <span style="font-size: 15px;">Mot de passe oublié?</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-5">
                                    <a href="<?php echo e(route('register')); ?>" class="text-center">
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
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo e(asset('js/waitMe.js')); ?>"></script>

    <script>
    function showLoading() {
        document.querySelector('#loading').classList.add('loading');
        document.querySelector('#loading-content').classList.add('loading-content');
    }

    // Cache le spinner de chargement
    function hideLoading() {
        document.querySelector('#loading').classList.remove('loading');
        document.querySelector('#loading-content').classList.remove('loading-content');
    }

    document.getElementById("loginform").addEventListener("submit", function(event) {
        showLoading(); // Affiche le spinner au moment de la soumission du formulaire
    });
    </script>
</body>

</html><?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/auth/login.blade.php ENDPATH**/ ?>