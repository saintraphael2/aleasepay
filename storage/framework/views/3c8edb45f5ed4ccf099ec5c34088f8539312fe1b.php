<div class="row input-daterange">

<div class="form-group col-sm-2">
<a  href="<?php echo e(route('commandeBordereau.form')); ?>" type="submit"  id="commander" class="btn btn-primary btnSubmit">Commander</a>
</div>
</div>
<?php if(!empty($bordereaux)): ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Compte</th>
                    <th>Type Bordereau</th>
                    <th>Date de commande</th>
                    <th>Quantité</th>
                    <th>numéro Ordre</th>
                    <th>Etat </th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $bordereaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bordereau): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($bordereau['compte']); ?></td>
                        <td><?php echo e($bordereau['libelleBordereau']); ?></td>
                        <td><?php echo e($bordereau['dateCommande']); ?></td>
                        <td><?php echo e($bordereau['quantite']); ?>  </td>
                        <td><?php echo e($bordereau['numeroOrdre']); ?></td>
                        <td>
    <?php if(isset($bordereau['etat'])): ?>
        <?php switch($bordereau['etat']):
            case ('0'): ?>
                <a>En attente</a>
                <?php break; ?>
            <?php case ('1'): ?>
                <a>En cours</a>
                <?php break; ?>
            <?php case ('2'): ?>
                <a>Validé</a>
                <?php break; ?>
            <?php default: ?>
                <a>État inconnu</a>
        <?php endswitch; ?>
    <?php else: ?>
        <a>État non défini</a>
    <?php endif; ?>
</td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun bordereau trouvé.</p>
    <?php endif; ?>

    <?php /**PATH C:\Projets\aleasepay\resources\views/commandeBordereau/table.blade.php ENDPATH**/ ?>