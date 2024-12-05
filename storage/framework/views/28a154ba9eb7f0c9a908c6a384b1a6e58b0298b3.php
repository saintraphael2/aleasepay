{!! Form::open(['route' => ['<?php echo e($config->prefixes->getRoutePrefixWith('.')); ?><?php echo e($config->modelNames->camelPlural); ?>.destroy', $<?php echo e($config->primaryName); ?>], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('<?php echo $config->prefixes->getRoutePrefixWith('.'); ?><?php echo $config->modelNames->camelPlural; ?>.show', $<?php echo $config->primaryName; ?>) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('<?php echo $config->prefixes->getRoutePrefixWith('.'); ?><?php echo $config->modelNames->camelPlural; ?>.edit', $<?php echo $config->primaryName; ?>) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
<?php if($config->options->localized): ?>
        'onclick' => "return confirm('Are you sure?')"
<?php else: ?>
        'onclick' => 'return confirm("'.__('crud.are_you_sure').'")'
<?php endif; ?>

    ]) !!}
</div>
{!! Form::close() !!}
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\vendor\infyomlabs\adminlte-templates\src/../views/templates/scaffold/table/datatable/actions.blade.php ENDPATH**/ ?>