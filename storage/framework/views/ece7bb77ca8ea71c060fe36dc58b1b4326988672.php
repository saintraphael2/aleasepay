<?php echo Form::open(['route' => ['bordereaux.destroy', $id], 'method' => 'delete']); ?>

<div class='btn-group'>
    
    <a href="<?php echo e(route('bordereaux.edit', $id)); ?>" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    <?php echo Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => 'return confirm("Êtes vous sûr de supprimer la commande?")'

    ]); ?>

</div>
<?php echo Form::close(); ?>

<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/bordereaus/datatables_actions.blade.php ENDPATH**/ ?>