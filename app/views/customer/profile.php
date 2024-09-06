<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile - ShipOnline</title>
</head>
<body>
    <h1>Customer Profile</h1>
    <p>Company Name: <?php echo $customer['company_name']; ?></p>
    <p>Contact Name: <?php echo $customer['contact_name']; ?></p>
    <p>Phone: <?php echo $customer['phone']; ?></p>
    <p>Address: <?php echo $customer['address']; ?></p>
</body>
</html>