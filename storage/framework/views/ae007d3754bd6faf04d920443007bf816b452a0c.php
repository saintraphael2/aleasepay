

<?php $__env->startSection('content'); ?>
<div class="card" style="padding: 15px;">
    <div class="container">

        <h2>Commande d'un bordereau</h2>

        <form action="<?php echo e(route('commandeBordereau.docommand')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <?php echo e($errors->first()); ?>

            </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="dateCommande" class="form-label">Date commande</label>
                <input type="text" id="dateCommande" name="dateCommande" value="<?php echo e($dateCommande); ?>" class="form-control" readonly/>
            </div>

            <div class="mb-3">
                <label for="reference" class="form-label">Type de bordereau</label>
                <select name="code" id="code" class='form-control'>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type['code']); ?>"><?php echo e($type['libelle']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
            </div>
            <div class="mb-3">
                <label for="quantite" class="form-label">Quantité</label>
                <input type="int" id="quantite" name="quantite" class="form-control"
                  />
            </div>
            <div class="mb-3">
                <label for="compte" class="form-label">Compte</label>
                <select id="compte" name="compte" class="form-select form-control" required>
                    <option value="">-- Sélectionnez un compte --</option>
                    <?php $__currentLoopData = $comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($compte->compte); ?>"><?php echo e($compte->compte); ?></option>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success btnSubmit">Commander</button>
            <a class="btn btn-danger btnSubmit "onclick="window.location.href='/bordereau/cancel'" id="btnCancel">
                Annuler
            </a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('page_scripts'); ?>
<script>

function cancel(){
    $.ajax({
        url: "/bordereau/cancel",
        method: "GET",
        contentType: "application/json",
        data: { 
         },
        success: function (response) {
        alert(1);
        },
        error: function (xhr) {
            let errorMessage = xhr.responseJSON?.error || "Serveur temporairement indisponible. Veuillez réessayer plus tard.";
            $("#error-messages").html(errorMessage);
            $("#error-alert").removeClass("d-none");
        }
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projets\aleasepay\resources\views/commandeBordereau/form.blade.php ENDPATH**/ ?>