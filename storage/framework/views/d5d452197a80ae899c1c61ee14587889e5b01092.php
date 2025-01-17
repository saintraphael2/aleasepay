

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    
    <br><br>
    <div class="content px-3">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>Compte 1</h3>
                        <p></p><br>
                        Intitulé: <b><?php echo e($cptClients[0]->intitule); ?></b> <br>
                        Numéro de compte: <b><?php echo e($cptClients[0]->compte); ?></b> <br>
                        Solde: <b><?php echo e(number_format($cptClients[0]->solde, 0,"", " ")); ?></b> <br>
                    </div>
                    <div class="icon">
                        <i class="fas fa fa-wallet"></i>
                    </div>
                    <span class="small-box-footer">
                        <i class="fas fa-arrow-circle-right"></i>
                    </span>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3> Compte 2</h3>
                        <p></p><br>
                        <?php if(isset($cptClients[1])): ?>
                        Intitulé: <b><?php echo e($cptClients[1]->intitule); ?></b> <br>
                        Numéro de compte: <b><?php echo e($cptClients[1]->compte); ?></b> <br>
                        Solde: <b><?php echo e(number_format($cptClients[1]->solde, 0,"", " ")); ?></b> <br>
                        <?php else: ?>
                        <br><br><br>
                        <?php endif; ?>
                    </div>
                    <div class="icon">
                        <i class="fas fa fa-wallet"></i>
                    </div>
                    <span href="" class="small-box-footer">
                        <i class="fas fa-arrow-circle-right"></i>
                    </span>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3> Compte 3</h3>
                        <p></p><br>
                        <?php if(isset($cptClients[2])): ?>
                        Intitulé: <b><?php echo e($cptClients[2]->intitule); ?></b> <br>
                        Numéro de compte: <b><?php echo e($cptClients[2]->compte); ?></b> <br>
                        Solde: <b><?php echo e(number_format($cptClients[2]->solde, 0,"", " ")); ?></b> <br>
                        <?php else: ?>
                        <br><br><br>
                        <?php endif; ?>
                    </div>
                    <div class="icon">
                        <i class="fas fa fa-wallet"></i>
                    </div>
                    <span href="" class="small-box-footer">
                        <i class="fas fa-arrow-circle-right"></i>
                    </span>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3> Compte 4</h3>
                        <p></p><br>
                        <?php if(isset($cptClients[3])): ?>
                        Intitulé: <b><?php echo e($cptClients[3]->intitule); ?></b> <br>
                        Numéro de compte: <b><?php echo e($cptClients[3]->compte); ?></b> <br>
                        Solde: <b><?php echo e(number_format($cptClients[3]->solde, 0,"", " ")); ?></b> <br>
                        <?php else: ?>
                        <br><br><br>
                        <?php endif; ?>
                    </div>
                    <div class="icon">
                        <i class="fas fa fa-wallet"></i>
                    </div>
                    <span href="" class="small-box-footer">
                        <i class="fas fa-arrow-circle-right"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\kokou.djimissa\OneDrive - AFRICAN LEASE GROUP SA\Documents\Projets\altprojects\aleasepay\resources\views/home.blade.php ENDPATH**/ ?>