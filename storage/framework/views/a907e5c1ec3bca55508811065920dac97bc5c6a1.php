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
    <img src="./images/cnss_logo.png" alt="CNSS" style="width: 250px; height: 100px;">
    <img src="./images/african_lease_logo.png" alt="African Lease" style="width: 250px; height: 100px;">
   </div>
        <!--div>
        <img src="./images/cnss_logo.png" alt="CNSS Logo">
        <img src="./images/african_lease_logo.png"  alt="African Lease Logo">
        </div-->
        <h2>Reçu Paiement Cotisation CNSS</h2>

        <table>
            <tr>
                <th>Référence CNSS</th>
                <th>Référence de paiement ALT</th>
                <th>Date de paiement</th>
                <th>Montant</th>
                <th>Frais</th>
            </tr>
            <tr>
                <td><?php echo e($transaction['refDecla']); ?></td>
                <td><?php echo e($transaction['referenceTransaction']); ?></td>
                <td><?php echo e($transaction['transBankDate']); ?></td>
                <td><?php echo e($transaction['mount']); ?></td>
                <td>12340009899U99E99.0</td>
            </tr>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\Projets\aleasepay\resources\views/transactions/quittance.blade.php ENDPATH**/ ?>