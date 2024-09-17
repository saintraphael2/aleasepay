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

</head>

<body class="hold-transition login-page opqone">
    <div class="login-box" style="width:700px !important">
        <!--div class="login-logo">
            <a href="<?php echo e(url('/home')); ?>"><b><?php echo e(config('app.name')); ?></b></a>
        </div-->
        <!-- /.login-logo -->

        <!-- /.login-box-body -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12" style="padding-bottom: 350px;">
                    <div class="card ">
                        <div class="card-header" style="text-align: center;">
                            <h4> Entrez le code de verification envoyé à votre adresse e-mail <?php echo e($emailc); ?></h4>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('validationOtp')); ?>">
                                <?php echo csrf_field(); ?>

                                <div class="row">
                                    <div class="col-4" style="text-align: right;">
                                        <label for="email" class="text-md-end">CODE</label>

                                    </div>
                                    <div class="col-8">
                                        <input id="otp" type="text"
                                            class="form-control <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="otp"
                                            value="<?php echo e(old('otp')); ?>" required>
                                        <input id="email" type="hidden"
                                            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                                            value="<?php echo e($email); ?>" required>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>

    </div>
    <!-- /.login-box -->

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>

</body>

</html><?php /**PATH C:\Users\kokou.djimissa\Documents\Projets\altprojects\aleasepay\resources\views/auth/otp.blade.php ENDPATH**/ ?>