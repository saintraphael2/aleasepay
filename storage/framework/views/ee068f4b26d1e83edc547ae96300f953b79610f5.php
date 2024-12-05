<!-- <?php echo e($fieldTitle); ?> Field -->
<div class="form-group col-sm-6">
<?php if($config->options->localized): ?>
    {!! Form::label('<?php echo e($fieldName); ?>', __('models/<?php echo e($config->modelNames->camelPlural); ?>.fields.<?php echo e($fieldName); ?>').':') !!}
<?php else: ?>
    {!! Form::label('<?php echo e($fieldName); ?>', '<?php echo e($fieldTitle); ?>:') !!}
<?php endif; ?>
    {!! Form::text('<?php echo e($fieldName); ?>', null, ['class' => 'form-control','id'=>'<?php echo e($fieldName); ?>']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#<?php echo e($fieldName); ?>').datepicker()
    </script>
@endpush<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\vendor\infyomlabs\adminlte-templates\src/../views/templates/fields/date.blade.php ENDPATH**/ ?>