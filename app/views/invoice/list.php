<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices - ShipOnline</title>
</head>
<body>
    <h1>Your Invoices</h1>
    <ul>
    <?php foreach ($invoices as $invoice): ?>
        <li>
            Invoice ID: <?php echo $invoice['invoice_id']; ?> - 
            Date: <?php echo $invoice['invoice_date']; ?> - 
            Due Date: <?php echo $invoice['due_date']; ?> - 
            Total: $<?php echo $invoice['total_amount']; ?> - 
            Status: <?php echo $invoice['status']; ?>
        </li>
    <?php endforeach; ?>
    </ul>
</body>
</html>