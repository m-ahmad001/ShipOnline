<?php
session_start();

require_once __DIR__ . '/app/controllers/UserController.php';
require_once __DIR__ . '/app/controllers/ShipmentController.php';

$userController = new UserController();
$shipmentController = new ShipmentController();

$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];

// Remove query string from the URL and get the path
$path = parse_url($request_uri, PHP_URL_PATH);

// Remove leading slash and trailing slash (if any)
$path = trim($path, '/');

// If path is empty, set it to home
if (empty($path)) {
    $path = 'shiponline';
}



switch ($path) {
    case 'shiponline':
        require __DIR__ . '/app/views/shiponline.php';
        break;

    case 'shiponline/register':
        if ($request_method === 'GET') {
            require __DIR__ . '/app/views/user/register.php';
        } elseif ($request_method === 'POST') {
            $result = $userController->register($_POST['name'], $_POST['email'], $_POST['password'], $_POST['mobileNumber']);
            if (is_numeric($result)) {
                $_SESSION['user_id'] = $result;
                $_SESSION['name'] = $_POST['name'];
                header('Location: /shiponline/shipment/create');
                exit();
            } else {
                $error = $result; // Assuming $result contains the error message
                require __DIR__ . '/app/views/user/register.php';
            }
        }
        break;

    case 'shiponline/login':
        if ($request_method === 'GET') {
            require __DIR__ . '/app/views/user/login.php';
        } elseif ($request_method === 'POST') {
            $user = $userController->login($_POST['mobileNumber'], $_POST['password']);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /shiponline/shipment/create');
                echo "Login successful";
            } else {
                $error = "Invalid mobile number or password";
                require __DIR__ . '/app/views/user/login.php';
            }
        }
        break;

    case 'shiponline/shipment/create':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /shiponline/');
            exit();
        }
        if ($request_method === 'GET') {
            require __DIR__ . '/app/views/shipment/request.php';
        } elseif ($request_method === 'POST') {
            // Validate inputs
            $errors = [];

            // Check if all inputs are given
            $required_fields = ['item_description', 'weight', 'pickup_address', 'pickup_suburb', 'pickup_date', 'pickup_time', 'receiver_name', 'delivery_address', 'delivery_suburb', 'delivery_state'];
            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    $errors[] = "All fields are required.";
                    break;
                }
            }

            // Validate weight (if not using a dropdown)
            if (!is_numeric($_POST['weight']) || $_POST['weight'] < 2 || $_POST['weight'] > 20) {
                $errors[] = "Weight must be between 2 and 20 kg.";
            }

            // Validate pickup date and time
            $pickup_datetime = strtotime($_POST['pickup_date'] . ' ' . $_POST['pickup_time']);
            $min_pickup_time = strtotime('+24 hours');
            if ($pickup_datetime < $min_pickup_time) {
                $errors[] = "Pickup time must be at least 24 hours from now.";
            }

            $pickup_hour = date('H', $pickup_datetime);
            if ($pickup_hour < 8 || $pickup_hour >= 20) {
                $errors[] = "Pickup time must be between 8:00 and 20:00.";
            }

            if (empty($errors)) {
                $result = $shipmentController->createShipmentRequest(
                    $_SESSION['user_id'],
                    $_POST['item_description'],
                    $_POST['weight'],
                    $_POST['pickup_address'],
                    $_POST['pickup_suburb'],
                    $_POST['pickup_date'],
                    $_POST['pickup_time'],
                    $_POST['receiver_name'],
                    $_POST['delivery_address'],
                    $_POST['delivery_suburb'],
                    $_POST['delivery_state']
                );

                if ($result['success']) {
                    $weight = (int) $_POST['weight'];
                    $cost = 20 + max(0, $weight - 2) * 3;
                    $success_message = "Thank you! Your request number is {$result['message']}. The cost is \${$cost}. We will pick-up the item at {$_POST['pickup_time']} on {$_POST['pickup_date']}.";
                } else {
                    $error_message = $result['message'];
                }
            } else {
                $error_message = implode(' ', $errors);
            }
            require __DIR__ . '/app/views/shipment/request.php';
        }
        break;

    case 'shiponline/admin':

        if ($request_method === 'GET') {
            require __DIR__ . '/app/views/admin/admin.php';
        } elseif ($request_method === 'POST') {
            $shipments = $shipmentController->getShipmentsByDate($_POST['date'], $_POST['date_type']);

            require __DIR__ . '/app/views/admin/admin.php';
        }
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
