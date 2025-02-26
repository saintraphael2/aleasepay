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
            width: 50%;
            margin: auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 80px;
        }
        h2 {
            border: 1px dashed #000;
            display: inline-block;
            padding: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="../img/cnss_logo.png" alt="CNSS Logo">
            <img src="../img/african_lease_logo.png" alt="African Lease Logo">
        </div>
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
                <td>{{ $others['refDecla'] }}</td>
                <td>{{ $others['referenceTransaction'] }}</td>
                <td>{{ $others['transBankDate'] }}</td>
                <td>{{ $others['mount'] }}</td>
                <td>0.0</td>
            </tr>
        </table>
    </div>
</body>
</html>
