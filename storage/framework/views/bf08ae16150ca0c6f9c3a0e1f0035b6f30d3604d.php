<?php if($config->options->localized): ?>
    '<?php echo e($fieldName); ?>' => new Column(['title' => __('models/<?php echo e($config->modelNames->camelPlural); ?>.fields.<?php echo e($fieldName); ?>'), 'data' => '<?php echo e($fieldName); ?>'])
<?php else: ?>
    '<?php echo e($fieldName); ?>'
<?php endif; ?><?php /**PATH D:\Dev\internetBanking\aleasepay2.0\vendor\infyomlabs\adminlte-templates\src/../views/templates/scaffold/table/datatable/column.blade.php ENDPATH**/ ?>