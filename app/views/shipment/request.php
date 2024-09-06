<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Shipment Request - ShipOnline</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 10px 0px;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        form {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 400px;
        }

        h1,
        h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #3498db;
        }

        p {
            font-size: 16px;
        }

        .success-message {
            color: green;
            font-weight: bold;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
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
    <form method="post">
        <h1>Create Shipment Request</h1>

        <h2>Item Information</h2>
        <input type="text" name="item_description" placeholder="Item Description" required>
        <select name="weight" id="weight" required onchange="calculatePrice()">
            <?php for ($i = 2; $i <= 20; $i++) {
                echo "<option value='$i'>$i kg</option>";
            } ?>
        </select>

        <h2>Pick-up Information</h2>
        <input type="text" name="pickup_address" placeholder="Pick-up Address" required>
        <input type="text" name="pickup_suburb" placeholder="Pick-up Suburb" required>
        <!-- <input type="date" name="pickup_date" required>
        <input type="time" name="pickup_time" required> -->
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
            <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </form>
</body>

</html>