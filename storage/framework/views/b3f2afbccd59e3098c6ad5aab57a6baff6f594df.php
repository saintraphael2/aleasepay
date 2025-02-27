

<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transactions</h1>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="clearfix"></div>
    <div class="card" style="padding: 15px;">
      
        <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <?php echo e($errors->first()); ?>

        </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(route('commandeBordereau.filter')); ?>" class="mb-4">
        <?php echo csrf_field(); ?>
            <div class="row input-daterange">
                <div class="form-group col-sm-2">
                    <?php echo Form::label('compte', 'Comptes :'); ?>

                    <select name="compte" id="compte" class='form-control'>
                        <?php $__currentLoopData = $comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($compte->compte); ?>"><?php echo e($compte->compte); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="text-danger font-size-xsmall error_date_debut"></span>
                </div>
                <div class="form-group col-sm-2">
                    <?php echo Form::label('type', 'Types :'); ?>

                    <select name="typebordereau" id="type" class='form-control'>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type['code']); ?>"><?php echo e($type['libelle']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <!-- Date Signature Field -->
                <div class="form-group col-sm-3">
                    <?php echo Form::label('date_debut', 'Date début (jj-mm-aaaa) :'); ?>

                    <?php echo Form::text('date_debut', null, ['class' => 'form-control','id'=>'date_debut']); ?>

                    <span class="text-danger font-size-xsmall error_date_debut"></span>
                </div>
                <!-- Date Debut Field -->
                <div class="form-group col-sm-3">
                    <?php echo Form::label('date_fin', 'Date fin (jj-mm-aaaa) :'); ?>

                    <?php echo Form::text('date_fin', null, ['class' => 'form-control','id'=>'date_fin']); ?>

                    <span class="text-danger font-size-xsmall error_date_fin"></span>
                </div>
                <div class="form-group col-sm-2" style="margin-top: 2rem;">
                    <button type="submit" id=""  class="btn btn-primary btnSubmit">Filtrer</button>
                </div>
            </div>
        </form>
        <?php echo $__env->make('commandeBordereau.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<script>
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('page_scripts'); ?>
<script>
$('#date_debut').datepicker({
    minDate: -90,
    maxDate: -1
})
$('#date_fin').datepicker({
    minDate: -89,
    maxDate: '0'
})


$('#filter').click(function() {
    let fromDate = $('#date_debut').val()
    let toDate = $('#date_fin').val()
    let redirect_url = "transactions/search?comptealt=" + $('#compte option:selected').text() + "&typeTransaction=" + $('#type option:selected').text()

    if (fromDate != '' && toDate != '') {

        redirect_url += "&dateDebut=" + fromDate + "&dateFin=" + toDate
    }

    /*
    //alert('Both Date is required')
    let erreur = {
        responseJSON : {message : "Les deux dates sont obligatoires"}
    }
    showError(erreur, "")*/

    console.log("redirect Url : ", redirect_url)
    window.location.href = redirect_url
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projets\aleasepay\resources\views/commandeBordereau/index.blade.php ENDPATH**/ ?>