    public function <?php echo e($functionName); ?>(): \Illuminate\Database\Eloquent\Relations\<?php echo e($relationClass); ?>

    {
        return $this-><?php echo e($relation); ?>(\<?php echo e($config->namespaces->model); ?>\<?php echo e($relatedModel); ?>::class<?php echo $fields; ?>);
    }<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/vendor/laravel-generator/model/relationship.blade.php ENDPATH**/ ?>