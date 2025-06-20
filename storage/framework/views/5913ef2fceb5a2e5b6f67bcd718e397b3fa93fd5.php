<?php if(!empty($transactions)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>reference Transaction</th>
                    <th>Désignation</th>
                    <th>Demandeur</th>
                    <th>Date</th>
                    <th>Montant TTC</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($transaction['referenceTransaction']); ?></td>
                        <td><?php echo e($transaction['contribuable']); ?></td>
                        <td><?php echo e($transaction['nif']); ?></td>
                        <td><?php echo e($transaction['transBankDate']); ?>  </td>
                        <td><?php echo e(number_format($transaction['mountTTC'], 0, ',', ' ')); ?> FCFA</td>
                        <td> 
                            <a class="btn btn-primary"
                             href="<?php echo e(route('transaction.quittance', ['transaction' => $transaction['referenceTransaction']])); ?>" target="_blank">
                            Quittance PDF </a> 
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune transaction trouvée.</p>
    <?php endif; ?>

    <?php /**PATH C:\Projets\aleasepay\resources\views/transactions/table.blade.php ENDPATH**/ ?>