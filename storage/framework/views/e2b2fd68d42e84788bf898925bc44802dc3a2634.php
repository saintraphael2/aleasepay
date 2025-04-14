

<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> Etax OTR</h1>
            </div>
            <div class="col-sm-6">
                <!-- <a class="btn btn-primary float-right"
                       href="<?php echo e(route('cptClients.create')); ?>">
                        Add New
                    </a> -->
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="clearfix"></div>
    <div class="card" style="padding: 15px;">
        <form method="GET" action="<?php echo e(route('otr.etax.search')); ?>" class="mb-4">
            <?php echo csrf_field(); ?>
            <div class="form-group ">
                <label for="reference_taxe">Référence de taxe</label>
                <input type="text" name="reference_taxe" id="reference_taxe" class="form-control col-sm-3"
                    placeholder="Entrez la reférence de taxe" value="<?php echo e(old('reference_taxe', $reference_taxe ?? '')); ?>"
                    required>
            </div>
            <button type="submit" class="btn btn-primary mt-2 btnSubmit">Rechercher</button>
        </form>
    </div>
    <?php if(!empty($etax)): ?>
    <div class="card" style="padding: 15px;">

        <div class="container">

            <h4>Informations de la taxe</h4>

            <form action="<?php echo e(route('otr.etax.pay')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <?php echo e($errors->first()); ?>

                </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="referenceDeclaration" class="form-label">Référence Déclaration</label>
                    <input type="text" id="referenceDeclaration" name="referenceDeclaration" class="form-control"
                        value="<?php echo e($etax['referenceDeclaration']); ?>" readonly>
                        <input type="hidden" id="referenceTransaction" name="referenceTransaction" class="form-control"
                        value="<?php echo e($etax['referenceTransaction']); ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="contribuable" class="form-label">Contribuable</label>
                    <input type="text" id="contribuable" name="contribuable" class="form-control"
                        value="<?php echo e($etax['contribuable']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="nif" class="form-label">NIF</label>
                    <input type="text" id="nif" name="nif" class="form-control"
                        value="<?php echo e($etax['nif']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant</label>
                    <input type="text" id="montant" name="montant" class="form-control"
                        value="<?php echo e(number_format($etax['montant'], 0, ',', ' ')); ?> FCFA" readonly>
                </div>

                <div class="mb-3">
                    <label for="compte" class="form-label">Compte</label>
                    <select id="compte" name="comptealt" class="form-select form-control" required>
                        <option value="">-- Sélectionnez un compte --</option>
                        <?php $__currentLoopData = $cptClientsOriginal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valeur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($valeur['compte']); ?>"><?php echo e($valeur['compte']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success btnSubmit">Effectuer le Paiement</button>
              
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projets\aleasepay\resources\views/otr/etax.blade.php ENDPATH**/ ?>