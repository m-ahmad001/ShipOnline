<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - ShipOnline</title>
</head>
<body>
    <h1>Products</h1>
    <ul>
    <?php foreach ($products as $product): ?>
        <li>
            <?php echo $product['name']; ?> - 
            <?php echo $product['description']; ?> - 
            Weight: <?php echo $product['weight']; ?>kg - 
            Price: $<?php echo $product['price']; ?>
        </li>
    <?php endforeach; ?>
    </ul>
</body>
</html>