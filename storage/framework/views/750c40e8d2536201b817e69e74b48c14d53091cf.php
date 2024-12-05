<?php $__env->startPush('third_party_stylesheets'); ?>
    <?php echo $__env->make('layouts.datatables_css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<div class="card-body px-4">
    <?php echo $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']); ?>

</div>

<?php $__env->startPush('third_party_scripts'); ?>
    <?php echo $__env->make('layouts.datatables_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $dataTable->scripts(); ?>

<?php $__env->stopPush(); ?>
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/bordereaus/table.blade.php ENDPATH**/ ?>