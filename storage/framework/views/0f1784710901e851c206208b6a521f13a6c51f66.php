<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cotisation CNSS</h1>
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
        <form method="GET" action="<?php echo e(route('cnss.cotisations.search')); ?>" class="mb-4">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <?php echo e($errors->first()); ?>

            </div>
            <?php endif; ?>
            <div class="form-group ">
                <label for="numero_employeur">Numéro d'employeur</label>
                <input type="text" name="numero_employeur" id="numero_employeur" class="form-control col-sm-3"
                    placeholder="Entrez le numéro d'employeur"
                    value="<?php echo e(old('numero_employeur', $numero_employeur ?? '')); ?>" required>
            </div>
            <button id="" type="submit" class="btn btn-primary mt-2 btnSubmit">Rechercher</button>
        </form>
    </div>
    <div class="card" style="padding: 15px;">
        <?php echo $__env->make('cnss.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<script>


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/akra4603/public_html/aleasepay/resources/views/cnss/cotisations.blade.php ENDPATH**/ ?>