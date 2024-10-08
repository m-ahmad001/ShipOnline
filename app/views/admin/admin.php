<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            max-width: 1000px;
            width: 100%;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="date"],
        button {
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .card {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            overflow-x: auto;
            display: block;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background-color: #f8f9fa;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            th,
            td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Administration - View Requests</h1>
        <form method="post">
            <label>
                <input type="radio" name="date_type" value="request_date" required> Request Date
            </label>
            <label>
                <input type="radio" name="date_type" value="pickup_date" required> Pick-up Date
            </label>
            <label>
                Select Date:
                <input type="date" name="date" required>
            </label>
            <button type="submit">Show</button>
        </form>

        <?php if (isset($shipments)): ?>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <?php if ($_POST['date_type'] == 'request_date'): ?>
                                <th>Customer Number</th>
                                <th>Request Number</th>
                                <th>Item Description</th>
                                <th>Weight</th>
                                <th>Pick-up Suburb</th>
                                <th>Preferred Pick-up Date</th>
                                <th>Delivery Suburb</th>
                                <th>Delivery State</th>
                            <?php else: ?>
                                <th>Customer ID</th>
                                <th>Customer Name</th>
                                <th>Contact Phone</th>
                                <th>Request Number</th>
                                <th>Item Description</th>
                                <th>Weight</th>
                                <th>Pick-up Address</th>
                                <th>Pick-up Suburb</th>
                                <th>Preferred Pick-up Time</th>
                                <th>Delivery Suburb</th>
                                <th>Delivery State</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($shipments as $shipment): ?>
                            <tr>
                                <?php if ($_POST['date_type'] == 'request_date'): ?>
                                    <td><?php echo htmlspecialchars($shipment['customer_id']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['request_number']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['item_description']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['weight']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['pickup_suburb']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['pickup_date']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['delivery_suburb']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['delivery_state']); ?></td>
                                <?php else: ?>
                                    <td><?php echo htmlspecialchars($shipment['customer_id']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['name']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['mobileNumber']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['request_number']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['item_description']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['weight']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['pickup_address']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['pickup_suburb']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['pickup_time']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['delivery_suburb']); ?></td>
                                    <td><?php echo htmlspecialchars($shipment['delivery_state']); ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="summary">
                <?php if ($_POST['date_type'] == 'request_date'): ?>
                    <p>Total number of requests: <?php echo count($shipments); ?></p>
                    <p>Total revenue: $<?php echo number_format(array_sum(array_column($shipments, 'total_cost')), 2); ?></p>
                <?php else: ?>
                    <p>Total number of requests: <?php echo count($shipments); ?></p>
                    <p>Total weight: <?php echo array_sum(array_column($shipments, 'weight')); ?> kg</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>