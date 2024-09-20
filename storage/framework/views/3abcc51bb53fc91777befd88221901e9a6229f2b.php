<html>
    <head>
    <link href="./css/app.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./vendor/UIjs/themes/base/jquery-ui.css">
    <style>
.page-break {
    page-break-after: always;
}
    </style>
    </head>
    <body style="font-family:Verdana; font-size:10px!important">
    
    <table class="table table-striped table-bordered dataTable no-footer " cellspacing="0">
            <tr>
            <th style='width:50px'>Date</th>
                <th>Désignation</th>
                <th>Débit</th>
                <th>Crédit</th>
            </tr>
            <?php $__currentLoopData = $mouvements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mouvement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style='line-height: 10px !important'>
                <td><?php echo e($mouvement->LOT_DATE->format('d-m-Y')); ?></td>
                    <td><?php echo e($mouvement->ECRCPT_LIBELLE); ?> <?php echo e($mouvement->ECRCPT_LIBCOMP); ?></td>
                    <td style="text-align:right">
                        <?php if($mouvement->ECRCPT_SENS=='D'): ?>
                            <?php echo e(number_format($mouvement->ECRCPT_MONTANT, 0,"", " ")); ?>

                        <?php endif; ?>
                    </td>
                    <td style="text-align:right">

                    <?php if($mouvement->ECRCPT_SENS=='C'): ?>
                    <?php echo e(number_format($mouvement->ECRCPT_MONTANT, 0,"", " ")); ?>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           </table>
           <div class="page-break"></div>

       
    </body>
</html><?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/mouvements/releve.blade.php ENDPATH**/ ?>