<html>
    <head>
    <link href="./css/app.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./vendor/UIjs/themes/base/jquery-ui.css">
    <style>
#footer {
  position: fixed;
  bottom: -60px;
  left: 0px;
  right: 0px;
  background-color: #ffffff;
  height: 50px;
}
#footer .page:after {
  content: counter(page, decimal);
}
    </style>
    </head>
    <body style="font-family:Verdana; font-size:10px!important">
    <div id="footer">
    <p class="page">Page </p>
</div>
    <div style="width: 100%;
            text-align: center;
            font-size: 14px;
            color: #555;">
        <div  style="float:left; width:100px"><img src="./images/logo.png" width='100' height='100'></div>
        <div style="float:right;text-align: center; width:100%" >RELEVE DES TRANSACTIONS <br>
        Compte : <b><?php echo e($compte); ?></b>     Du <b><?php echo e($deb); ?></b>  Au <b><?php echo e($fin); ?></b>
    </div>
    </div>
<div style='clear:both'></div>
    <div class="content">
    <?php $compteur=0;?>
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
    </div>
    
    <script type="text/php">
        if ( isset($pdf) ) { 
            $pdf->page_script('
                if ($PAGE_COUNT > 1) {
                    $font = $fontMetrics->get_font("Arial, sans-serif", "normal");
                    $size = 12;
                    $y = 15;
                    $x = 520;
                    $pdf->text($x, $y, "Page " . $PAGE_NUM . " of " . $PAGE_COUNT, $font, $size);
                }
            ');
        }
    </script>

       
    </body>
</html><?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/mouvements/releve.blade.php ENDPATH**/ ?>