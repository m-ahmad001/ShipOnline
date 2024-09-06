<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - ShipOnline</title>
</head>
<body>
    <h1>Your Orders</h1>
    <ul>
    <?php foreach ($orders as $order): ?>
        <li>
            Order ID: <?php echo $order['order_id']; ?> - 
            Date: <?php echo $order['order_date']; ?> - 
            Total: $<?php echo $order['total_amount']; ?> - 
            Status: <?php echo $order['status']; ?>
        </li>
    <?php endforeach; ?>
    </ul>
</body>
</html>