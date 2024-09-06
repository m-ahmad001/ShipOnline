<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Shipment Request - ShipOnline</title>
    <script>
        function calculatePrice() {
            const weight = document.getElementById('weight').value;
            const basePrice = 20;
            const additionalPrice = Math.max(0, weight - 2) * 3;
            const totalPrice = basePrice + additionalPrice;
            document.getElementById('price').textContent = '$' + totalPrice.toFixed(2);
        }
    </script>
</head>
<body>
    <h1>Create Shipment Request</h1>
    <form method="post">
        <h2>Item Information</h2>
        <input type="text" name="item_description" placeholder="Item Description" required>
        <select name="weight" id="weight" required onchange="calculatePrice()">
            <?php for ($i = 2; $i <= 20; $i++) { echo "<option value='$i'>$i kg</option>"; } ?>
        </select>

        <h2>Pick-up Information</h2>
        <input type="text" name="pickup_address" placeholder="Pick-up Address" required>
        <input type="text" name="pickup_suburb" placeholder="Pick-up Suburb" required>
        <input type="date" name="pickup_date" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
        <input type="time" name="pickup_time" required min="08:00" max="20:00">

        <h2>Delivery Information</h2>
        <input type="text" name="receiver_name" placeholder="Receiver Name" required>
        <input type="text" name="delivery_address" placeholder="Delivery Address" required>
        <input type="text" name="delivery_suburb" placeholder="Delivery Suburb" required>
        <select name="delivery_state" required>
            <option value="">Select State</option>
            <option value="NSW">New South Wales</option>
            <option value="VIC">Victoria</option>
            <option value="QLD">Queensland</option>
            <option value="WA">Western Australia</option>
            <option value="SA">South Australia</option>
            <option value="TAS">Tasmania</option>
            <option value="ACT">Australian Capital Territory</option>
            <option value="NT">Northern Territory</option>
        </select>

        <h2>Pricing</h2>
        <p>Price: <span id="price">$20.00</span></p>

        <button type="submit">Create Shipment Request</button>

        <?php if (isset($success_message)): ?>
            <p style="color: green; font-weight: bold;"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </form>
</body>
</html>