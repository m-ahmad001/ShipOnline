<?php
require_once 'app/models/Shipment.php';

class ShipmentController
{
    private $shipmentModel;

    public function __construct()
    {
        $this->shipmentModel = new Shipment();
    }

    public function getShipmentsByDate($date, $date_type)
    {
        if ($date_type === 'request_date') {
            return $this->shipmentModel->getRequestsByRequestDate($date);
        } elseif ($date_type === 'pickup_date') {
            return $this->shipmentModel->getRequestsByPickupDate($date);
        }
    }

    public function createShipmentRequest($customer_id, $item_description, $weight, $pickup_address, $pickup_suburb, $pickup_date, $pickup_time, $receiver_name, $delivery_address, $delivery_suburb, $delivery_state)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $error_message = $this->shipmentModel->validateInput($_POST);

            if (empty($error_message)) {
                $request_number = $this->shipmentModel->generateRequestNumber();
                $request_date = date('Y-m-d H:i:s');
                $cost = $this->shipmentModel->calculateCost($_POST['weight']);

                $shipmentData = [
                    'customer_id' => $customer_id,
                    'request_number' => $request_number,
                    'request_date' => $request_date,
                    'item_description' => $_POST['item_description'],
                    'weight' => $_POST['weight'],
                    'pickup_address' => $_POST['pickup_address'],
                    'pickup_suburb' => $_POST['pickup_suburb'],
                    'pickup_date' => $_POST['pickup_date'],
                    'pickup_time' => $_POST['pickup_time'],
                    'receiver_name' => $_POST['receiver_name'],
                    'delivery_address' => $_POST['delivery_address'],
                    'delivery_suburb' => $_POST['delivery_suburb'],
                    'delivery_state' => $_POST['delivery_state']
                ];

                if ($this->shipmentModel->createShipment($shipmentData)) {
                    // $customerInfo = $this->shipmentModel->getCustomerInfo($customer_id);
                    // $this->sendConfirmationEmail($customerInfo, $request_number, $cost, $_POST['pickup_date'], $_POST['pickup_time']);

                    $success_message = "Thank you! Your request number is {$request_number}. We will pick-up the item at {$_POST['pickup_time']} on {$_POST['pickup_date']}.";
                    // Return true if the shipment was created successfully, false otherwise
                    return [
                        'success' => true,
                        'message' => $success_message
                    ]; // Replace with actual success condition
                } else {
                    $error_message = "An error occurred while processing your request. Please try again.";
                    return [
                        'success' => false,
                        'message' => $error_message
                    ];
                }
            }
        }

        include 'app/views/shipment/create.php';
    }

    // ... rest of the controller code ...
}