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
            $result = $userController->register($_POST['username'], $_POST['email'], $_POST['password'], $_POST['mobileNumber']);
            if ($result) {
                $_SESSION['user_id'] = $result;
                header('Location: /shiponline/shipment/create');
                echo "Registration successful";
            } else {
                echo "Registration failed";
            }
        }
        break;

    case 'shiponline/login':
        if ($request_method === 'GET') {
            require __DIR__ . '/app/views/user/login.php';
        } elseif ($request_method === 'POST') {
            $user = $userController->login($_POST['username'], $_POST['password']);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo "Login successful";
            } else {
                echo "Login failed";
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
                $success_message = $result['message'];
            } else {
                $error_message = $result['message'];
            }
            require __DIR__ . '/app/views/shipment/request.php';
        }
        break;

    case 'shiponline/admin':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /shiponline/');
            exit();
        }
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
