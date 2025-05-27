

<?php $__env->startSection('content'); ?>
<div class="card" style="padding: 15px;">
    <div class="container">

        <h2>Paiement de Cotisation</h2>

        <form action="<?php echo e(route('cnss.cotisations.pay')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <?php echo e($errors->first()); ?>

            </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="numero_employeur" class="form-label">Numéro Employeur</label>
                <input type="text" id="numero_employeur" name="numero_employeur" class="form-control"
                    value="<?php echo e($numero_employeur); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="reference" class="form-label">Référence</label>
                <input type="text" id="reference" name="referenceID" class="form-control"
                    value="<?php echo e($cotisation['referenceID']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="designation" class="form-label">Désignation</label>
                <input type="text" id="designation" name="designation" class="form-control"
                    value="<?php echo e($cotisation['designation']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="requester" class="form-label">Demandeur</label>
                <input type="text" id="requester" name="requester" class="form-control"
                    value="<?php echo e($cotisation['requester']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="created_at" class="form-label">Date de création Cotisation</label>
                <input type="text" id="created_at" name="created_at" class="form-control"
                    value="<?php echo e($cotisation['created_at']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Montant TTC</label>
                <input type="text" id="amount" name="amount" class="form-control"
                    value="<?php echo e(number_format($cotisation['amount'], 0, ',', ' ')); ?> FCFA" readonly>
            </div>

            <div class="mb-3">
                <label for="compte" class="form-label">Compte</label>
                <select id="compte" name="comptealt" class="form-select form-control" required>
                    <option value="">-- Sélectionnez un compte --</option>
                    <?php $__currentLoopData = $cptClientsOriginal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valeur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($valeur['compte']); ?>"><?php echo e($valeur['compte']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
             <!--div class="mb-3">  
                <label for="amount" class="form-label">Libellé du compte</label>
                 <input type="text" id="libelleCompte" class="form-control" readonly>
            </div-->
            <button type="submit" class="btn btn-success btnSubmit">Effectuer le Paiement</button>
            <a href="<?php echo e(route('cnss.cotisations.search', ['numero_employeur' => $numero_employeur])); ?>" class="btn btn-danger btnSubmit">
                Annuler
            </a>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<!--script>
<?php $__env->startPush('scripts'); ?>
$(document).ready(function () {
    $('#compte').on('change', function () {
        var compte = $(this).val();
        if (compte) {
            $.ajax({
                url: "<?php echo e(route('bordereau.getCompteLibelle')); ?>",
                method: 'GET',
                data: { compte: compte },
                success: function (data) {
                    if (data && data.intitule) {
                        $('#libelleCompte').val(data.intitule);
                    } else {
                        $('#libelleCompte').val('Libellé non trouvé');
                    }
                },
                error: function () {
                    $('#libelleCompte').val('Erreur serveur');
                }
            });
        } else {
            $('#libelleCompte').val('');
        }
    });
});
<?php $__env->stopPush(); ?>
</script-->





<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projets\aleasepay\resources\views/cnss/form.blade.php ENDPATH**/ ?>