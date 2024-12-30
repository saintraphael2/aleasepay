<?php if(!empty($cotisations)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Désignation</th>
                    <th>Demandeur</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $cotisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cotisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($cotisation['referenceID']); ?></td>
                        <td><?php echo e($cotisation['designation']); ?></td>
                        <td><?php echo e($cotisation['requester']); ?></td>
                        <td><?php echo e($cotisation['created_at']); ?></td>
                        <td><?php echo e(number_format($cotisation['amount'], 0, ',', ' ')); ?> FCFA</td>

                        <td>
                        <?php if($cotisation['done'] == true): ?>
                            <button class="btn btn-secondary" disabled>Action (Désactivé)</button>
                        <?php else: ?>
                            <button class="btn btn-primary">Action (Actif)</button>
                        <?php endif; ?>
                    </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune cotisation trouvée.</p>
    <?php endif; ?><?php /**PATH C:\Users\kokou.djimissa\Documents\Projets\altprojects\aleasepay\resources\views/cnss/table.blade.php ENDPATH**/ ?>