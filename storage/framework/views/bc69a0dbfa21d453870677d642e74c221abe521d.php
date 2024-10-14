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

<body class="hold-transition login-page loginbodybackg" style="height: 600px !important;">
    <div class="row loginbodybackg">
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

                        <form method="post" action="<?php echo e(url('/login')); ?>">
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
    $(function() {

        var current_effect ='progress' ;
        //$('#waitMe_ex_effect').val()
        run_waitMe($('.containerBlock > form'), 1, current_effect);

        $('#waitMe_ex').click(function() {
           
        });
        $('.waitMe_ex_close').click(function() {
            $('.containerBlock > form').waitMe('hide');
            $('#waitMe_ex2').waitMe('hide');
            $('#waitMe_ex3').waitMe('hide');
        });

        $('#waitMe_ex_effect').change(function() {
            current_effect = $(this).val();
            run_waitMe($('.containerBlock > form'), 1, current_effect);
            run_waitMe($('#waitMe_ex2'), 2, current_effect);
            run_waitMe($('#waitMe_ex3'), 3, current_effect);
        });

        $('#waitMe_ex_effect').click(function() {
            current_effect = $(this).val();
        });

        function run_waitMe(el, num, effect) {
            text = 'Please wait...';
            fontSize = '';
            switch (num) {
                case 1:
                    maxSize = '';
                    textPos = 'vertical';
                    break;
                case 2:
                    text = '';
                    maxSize = 30;
                    textPos = 'vertical';
                    break;
                case 3:
                    maxSize = 30;
                    textPos = 'horizontal';
                    fontSize = '18px';
                    break;
            }
            el.waitMe({
                effect: effect,
                text: text,
                bg: 'rgba(255,255,255,0.7)',
                color: '#000',
                maxSize: maxSize,
                waitTime: -1,
                source: 'img.svg',
                textPos: textPos,
                fontSize: fontSize,
                onClose: function(el) {}
            });
        }

        $('#waitMe_ex2').click(function() {
            run_waitMe($(this), 2, current_effect);
        });

        $('#waitMe_ex3').click(function() {
            run_waitMe($(this), 3, current_effect);
        });

        var current_body_effect = $('#waitMe_ex_body_effect').val();

        $('#waitMe_ex_body').click(function() {
            run_waitMe_body(current_body_effect);
        });

        $('#waitMe_ex_body_effect').change(function() {
            current_body_effect = $(this).val();
            run_waitMe_body(current_body_effect);
        });

        function run_waitMe_body(effect) {
            $('body').addClass('waitMe_body');
            var img = '';
            var text = '';
            if (effect == 'img') {
                img = 'background:url(\'img.svg\')';
            } else if (effect == 'text') {
                text = 'Loading...';
            }
            var elem = $('<div class="waitMe_container ' + effect + '"><div style="' + img + '">' + text +
                '</div></div>');
            $('body').prepend(elem);

            setTimeout(function() {
                $('body.waitMe_body').addClass('hideMe');
                setTimeout(function() {
                    $('body.waitMe_body').find('.waitMe_container:not([data-waitme_id])')
                        .remove();
                    $('body.waitMe_body').removeClass('waitMe_body hideMe');
                }, 200);
            }, 4000);
        }

    });
    </script>
</body>

</html><?php /**PATH C:\Users\kokou.djimissa\Documents\Projets\altprojects\aleasepay\resources\views/auth/login.blade.php ENDPATH**/ ?>