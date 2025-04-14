<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: red;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .content {
            padding: 20px;
            color: #343a40;
        }
        .content h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #4CAF50;
        }
        .content p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .content ul {
            list-style-type: none;
            padding: 0;
        }
        .content ul li {
            font-size: 16px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .content ul li strong {
            color: #343a40;
        }
        .footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Transaction annulée</h1>
        </div>
        <div class="content">
            <p><?php echo e($msge); ?>. Voici les détails de la transaction :</p>
            <ul>
                <li><strong>Transaction Référence:</strong> <?php echo e($data['reference']); ?></li>
                <li><strong>Date de la Transaction:</strong> <?php echo e($data['date']); ?></li>
                <li><strong>Montant:</strong> <?php echo e($data['montant']); ?></li>
                <li><strong>Compte:</strong> <?php echo e($data['comptealt']); ?></li>
                <li><strong>Initiateur:</strong> <?php echo e($data['initiated_name']); ?></li>
            </ul>
        </div>
        <div class="footer">
            <p>Merci pour votre confiance.</p>
            <strong>Copyright &copy; 2024 <a class="copyrith" href="https://www.africanlease.com/">AFRICAN LEASE
                    TOGO</a>.</strong> Tous droits reservés
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Projets\aleasepay\resources\views/transactions_pending/email_cancel.blade.php ENDPATH**/ ?>