<!-- Client Field -->

   
    <?php echo Form::hidden('client', $client, ['class' => 'form-control']); ?>



<!-- Compte Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('compte', 'Compte:'); ?>

    <?php echo Form::select('compte', $comptes,null, ['class' => 'form-control', 'maxlength' => 12, 'maxlength' => 12]); ?>

</div>

<!-- Type Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('type', 'Type:'); ?>

    <?php echo Form::select('type',$type_bordereaux, null, ['class' => 'form-control']); ?>

</div>

<!-- Nombre Field -->
<div class="form-group col-sm-4">
    <?php echo Form::label('nombre', 'Nombre:'); ?>

    <?php echo Form::number('nombre', null, ['class' => 'form-control']); ?>

</div>
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/bordereaus/fields.blade.php ENDPATH**/ ?>