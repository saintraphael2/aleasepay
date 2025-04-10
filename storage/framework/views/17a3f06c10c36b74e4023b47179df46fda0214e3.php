<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Responsive Fullscreen</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
    integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
    crossorigin="anonymous" />

<!--link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet"-->
<link type="text/css" rel="stylesheet" href="<?php echo e(asset('css/waitMe.css')); ?>">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    .full-height {
      min-height: 100vh;
    }
    .iconlogin {
    font-size: 20px;
    padding: 5px;
    color: #fcd931 !important;
}
	.bg-secondary {
    --bs-bg-opacity: 1;
    background-color: #2e7518 !important;
}


.bg-primary {
    --bs-bg-opacity: 1;
    background-color: white !important;
}
.submitbtn{
    background-color:   #fcd931 !important;
}
.disabled-link {
    pointer-events: none; 
    opacity: 0.5; 
}

.loading {
    z-index: 20;
    position: absolute;
    top: 0;
    left: -5px;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
}

.loading-content {
    position: absolute;
    border: 10px solid #f3f3f3;
    border-top: 10px solid #fcd931;
    border-radius: 100%;
    width: 100px;
    height: 100px;
    top: 40%;
    left: 48%;
    animation: spin 2s linear infinite
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
  </style>
</head>
<body>

  <div class="container-fluid">
    <div class="row full-height ">
      <div class="col-12 col-md-6 text-white d-flex align-items-center justify-content-center " 
      style="background-image: url(../images/bg.jpg);background-size: contain;  
  background-position: center;  background-repeat: no-repeat;">
        <div class="text-center p-3" >
           
        </div>
      </div>
      <div class="col-12 col-md-6 bg-secondary text-white d-flex align-items-center justify-content-center">
        <div class="text-center p-3">
         <div class="login-box">
         <section id="loading" >
            <div id="loading-content" ></div>
        </section>
                <!-- /.login-logo -->
                <!-- /.login-box-body -->
                <div class="card logincardctz containerBlock">
               
                    <div class="card-body login-card-body">
                    
                        <!--p class="login-box-msg"><?php echo e(__('auth.login.title')); ?></p-->
							<div><a href="#"><b> <img src="../images/logoalt_new.PNG" style="width:50%"></b></a></div>
                        <div class="iconlogin">
                            <h4 class="login-box-msg" style="color:black !important;">Bienvenue sur AleasePay</h4>
                            <i class="fas fa-user"></i>
                        </div>
                        <?php if(Session::has('message')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(Session::get('message')); ?>

                        </div>
                        <?php endif; ?>
    <form method="POST" action="<?php echo e(url('/reset-password-frombackoffice')); ?>" id="formreset">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="token" value="<?php echo e($token); ?>">
        <input type="hidden" name="email" value="<?php echo e($email); ?>">
        <div class="form-group row">
                           
                            <div class="col-md-12  mb-3">
                                <input type="password" name="password"
                                    class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>"
                                    placeholder="Mot de Passe">
                                <?php if($errors->has('password')): ?>
                                <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                                <?php endif; ?>
                            </div>
        </div>
        <div class="form-group row">
                            <div class="col-md-12  mb-3">
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Confirmation Mot de passe">

                                <?php if($errors->has('password_confirmation')): ?>
                                <span class="text-danger"><?php echo e($errors->first('password_confirmation')); ?></span>
                                <?php endif; ?>
        </div>
        </div>
        <div class="row">
                            <div class="col-12">
                                <button type="submit" 
                                 class="btn btn-block submit-color submitbtn btnSubmit">Valider</button>
                            </div>  
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
                    <!-- /.login-card-body -->
                </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 
</body>

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

    document.getElementById("formreset").addEventListener("submit", function(event) {
        showLoading(); // Affiche le spinner au moment de la soumission du formulaire
    });
    </script>
</html>
<?php /**PATH C:\Projets\aleasepay\resources\views/auth/form_reset_password.blade.php ENDPATH**/ ?>