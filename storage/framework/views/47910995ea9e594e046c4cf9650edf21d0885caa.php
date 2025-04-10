

<?php $__env->startSection('content'); ?>
<section class="content-header" style="padding: 20px;">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1>
                    Attestation d'Identite Bancaire
                </h1>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    <div class="card">
        <div class="card-body">
            <?php $__currentLoopData = $cptClients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cptClient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row">
                <div class="col-12">
                    <div class="col-4" style="text-align: left;">
                        <a class="btn btn-primary" href="<?php echo e(route('attestation',$cptClient->compte)); ?>">
                            Exporter PDF
                        </a>
                    </div>
                    <div class="col-8" style="margin-top: 10px;">
                        <table class="col-12">
                            <tr style='border: 1px solid'>
                                <th>Code Banque</th>
                                <th>Code Guichet</th>
                                <th>Numéro de Compte</th>
                                <th>Clé RIB</th>
                            </tr>
                            <tr style='border: 1px solid'>
                                <td>TG215</td>
                                <td>01001</td>
                                <td><?php echo e($cptClient->compte); ?></td>
                                <td><?php echo e($cptClient->cle); ?></td>
                            </tr>
                            <tr style='border: 1px solid'>
                                <th colspan='3'>CODE IBAN</th>

                                <th>CODE BIC</th>
                            </tr>
                            <tr style='border: 1px solid'>
                                <td colspan='3'>TG53TG21501001<?php echo e($cptClient->compte); ?><?php echo e($cptClient->cle); ?></td>
                                <td>ALTBTGTG</td>

                            </tr>
                            <tr style='border: 1px solid'>

                                <td style="text-align:left">Intitulé du compte</td>
                                <td colspan='3' style="text-align:left;font-weight:bold"><?php echo e($cptClient->intitule); ?></td>
                            </tr>
                            <tr style='border: 1px solid'>

                                <td style="text-align:left">Devise</td>
                                <td colspan='3' style="text-align:left;font-weight:bold"><?php echo e($cptClient->devise_code); ?>

                                    <?php echo e($cptClient->devise_libelle); ?></td>
                            </tr>
                            <tr style='border: 1px solid'>

                                <td style="text-align:left">Domiciliation</td>
                                <td colspan='3' style="text-align:left;font-weight:bold">01.001 AFRICAN LEASE TOGO</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div>
                <p style='background-color:green'></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projets\aleasepay\resources\views/cpt_clients/rib.blade.php ENDPATH**/ ?>