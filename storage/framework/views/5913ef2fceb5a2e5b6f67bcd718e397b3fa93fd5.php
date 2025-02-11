<?php if(!empty($transactions)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>reference Transaction</th>
                    <th>Désignation</th>
                    <th>Demandeur</th>
                    <th>Date</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($transaction['referenceTransaction']); ?></td>
                        <td><?php echo e($transaction['contribuable']); ?></td>
                        <td><?php echo e($transaction['nif']); ?></td>
                        <td><?php echo e($transaction['transBankDate']); ?>  </td>
                        <td><?php echo e(number_format($transaction['mount'], 0, ',', ' ')); ?> FCFA</td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune transaction trouvée.</p>
    <?php endif; ?>

    <?php /**PATH C:\Projets\aleasepay\resources\views/transactions/table.blade.php ENDPATH**/ ?>