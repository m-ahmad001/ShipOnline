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

// Add CSS styles
echo '
<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        width: 80%;
        margin: auto;
        overflow: hidden;
        padding: 20px;
    }
    header {
        background: #35424a;
        color: #ffffff;
        padding-top: 30px;
        min-height: 70px;
        border-bottom: #e8491d 3px solid;
    }
    header a {
        color: #ffffff;
        text-decoration: none;
        text-transform: uppercase;
        font-size: 16px;
    }
    header ul {
        padding: 0;
        list-style: none;
    }
    header li {
        display: inline;
        padding: 0 20px 0 20px;
    }
    header #branding {
        float: left;
    }
    header #branding h1 {
        margin: 0;
    }
    header nav {
        float: right;
        margin-top: 10px;
    }
    .highlight, header .current a {
        color: #e8491d;
        font-weight: bold;
    }
</style>
';

switch ($path) {
    case 'shiponline':
        // Home page
        echo '
        <header>
            <div class="container">
                <div id="branding">
                    <h1><span class="highlight">Ship</span>Online</h1>
                </div>
                <nav>
                    <ul>
                        <li class="current"><a href="/shiponline">Home</a></li>
                        <li><a href="/shiponline/login">Login</a></li>
                        <li><a href="/shiponline/register">Register</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="container">
            <h2>Welcome to ShipOnline</h2>
            <p>Choose a component:</p>
            <ul>
                <li><a href="/shipment/create">Shipment Management</a></li>
                <li><a href="/customer/profile">Customer Management</a></li>
                <li><a href="/orders">Order Processing</a></li>
            </ul>
        </div>
        ';
        break;

    case 'shiponline/register':
        if ($request_method === 'GET') {
            require __DIR__ . '/app/views/user/register.php';
        } elseif ($request_method === 'POST') {
            $result = $userController->register($_POST['username'], $_POST['email'], $_POST['password']);
            if ($result) {
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
            exit;
        }
        if ($request_method === 'GET') {
            require __DIR__ . '/app/views/shipment/create.php';
        } elseif ($request_method === 'POST') {
            $result = $shipmentController->createShipment(
              $_SESSION['user_id'],
              $_POST['item_description'],
              $_POST['weight'],
              $_POST['origin'],
              $_POST['destination'],
              $_POST['weight'],
              $_POST['pickup_address'],
              $_POST['pickup_suburb'],
              $_POST['pickup_date'],
              $_POST['pickup_time'],
              $_POST['receiver_name'],
              $_POST['delivery_address'],
              $_POST['delivery_suburb'],
              $_POST['delivery_state'],

            );
            if ($result) {
                $success_message = "Shipment created successfully";
                require __DIR__ . '/app/views/shipment/create.php';
            } else {
                $error_message = "Failed to create shipment";
                require __DIR__ . '/app/views/shipment/create.php';
            }
        }
        break;

   
        if (!isset($_SESSION['user_id'])) {
            header('Location: shiponline/login');
            exit;
        }
        $customer = $customerController->getCustomerProfile($_SESSION['user_id']);
        require __DIR__ . '/app/views/customer/profile.php';
        break;

   
        $products = $productController->getAllProducts();
        // Render products view
        break;

   
        if (!isset($_SESSION['user_id'])) {
            header('Location: shiponline/login');
            exit;
        }
        if ($request_method === 'POST') {
            // Process order creation
            $customer = $customerController->getCustomerProfile($_SESSION['user_id']);
            $order_id = $orderController->createOrder($customer['customer_id'], $_POST['total_amount'], $_POST['items']);
            if ($order_id) {
                $invoiceController->createInvoice($order_id, $_POST['due_date'], $_POST['total_amount']);
                echo "Order created successfully";
            } else {
                echo "Failed to create order";
            }
        } else {
            // Render order creation form
        }
        break;

    case 'shiponline/admin/allorders':
        if (!isset($_SESSION['user_id'])) {
            header('Location: shiponline/login');
            exit;
        }
        $customer = $customerController->getCustomerProfile($_SESSION['user_id']);
        $orders = $orderController->getCustomerOrders($customer['customer_id']);
        // Render orders view
        break;

   
        if (!isset($_SESSION['user_id'])) {
            header('Location: shiponline/login');
            exit;
        }
        $customer = $customerController->getCustomerProfile($_SESSION['user_id']);
        $invoices = $invoiceController->getCustomerInvoices($customer['customer_id']);
        // Render invoices view
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}