<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu Paiement Cotisation CNSS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            width: 100%;
            /**margin: auto;**/
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-evenly; /* Ajoute plus d'espace entre les images */
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 2px solid black;
        }
        .header img {
            height: 80px;
            margin-left: 35px;
        }
        h2 {
            border: 1px dashed #000;
            display: inline-block;
            padding: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            /*height: 50%;*/
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            width:50%;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">

    <div  class="header" style="display: flex; justify-content: space-between; width: 100%;">
    <?php if($transaction['type_transaction']['operationMonetique'] == 'OOT'): ?>
    <img src="./images/otr_logo.png" alt="OTR" style="width: 250px; height: 100px;">
    <?php elseif($transaction['type_transaction']['operationMonetique'] == 'OCN'): ?>
    <img src="./images/cnss_logo.png" alt="CNSS" style="width: 250px; height: 100px">
    <?php endif; ?>
    <img src="./images/african_lease_logo.png" alt="African Lease" style="width: 320px; height: 100px;border:1.5px solid black;">
   </div>
        <!--div>
        <img src="./images/cnss_logo.png" alt="CNSS Logo">
        <img src="./images/african_lease_logo.png"  alt="African Lease Logo">
        </div-->
        <?php if($transaction['type_transaction']['operationMonetique'] == 'OOT'): ?>
        <h2>Reçu Paiement OTR</h2>
        <?php elseif($transaction['type_transaction']['operationMonetique'] == 'OCN'): ?>
        <h2>Reçu Paiement Cotisation CNSS</h2>
        <?php endif; ?>
        <table>
            <tr>
            <?php if($transaction['type_transaction']['operationMonetique'] == 'OOT'): ?>
                <th>Référence OTR</th>
                <?php elseif($transaction['type_transaction']['operationMonetique'] == 'OCN'): ?>
                <th>Référence CNSS</th>
                <?php endif; ?>
                <th>Référence de paiement ALT</th>
                <th>Date de paiement</th>
                <th>Montant</th>
                <th>Frais</th>
            </tr>
            <tr>
                <td><?php echo e($transaction['refDecla']); ?> </td>
                <td><?php echo e($transaction['referenceTransaction']); ?></td>
                <td><?php echo e($transaction['transBankDate']); ?></td>
                <td><?php echo e(number_format($transaction['mount'] , 0, ',', ' ')); ?> FCFA</td>
                <td><?php echo e(number_format($transaction['mountTTC'] - $transaction['mount'], 0, ',', ' ')); ?> FCFA
                    
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\Projets\aleasepay\resources\views/transactions/quittance.blade.php ENDPATH**/ ?>