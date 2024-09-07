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

    public function createShipmentRequest($userId, $itemDescription, $weight, $pickupAddress, $pickupSuburb, $pickupDate, $pickupTime, $receiverName, $deliveryAddress, $deliverySuburb, $deliveryState)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            if (empty($error_message)) {
                $request_number = $this->shipmentModel->generateRequestNumber();
                // $customerInfo = $this->shipmentModel->getCustomerInfo($userId);
                $request_date = date('Y-m-d');
                $cost = $this->shipmentModel->calculateCost($_POST['weight']);

                $shipmentData = [
                    'customer_id' => $userId,
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
                    'delivery_state' => $_POST['delivery_state'],
                ];

                $result = $this->shipmentModel->createShipment($shipmentData);

                if ($result) {

                    // $this->sendConfirmationEmail($customerInfo, $request_number, $cost, $_POST['pickup_date'], $_POST['pickup_time']);

                    $success_message = "Thank you! Your request number is {$request_number}. We will pick-up the item at {$_POST['pickup_time']} on {$_POST['pickup_date']}.";
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

    private function sendConfirmationEmail($customerInfo, $request_number, $cost, $pickupDate, $pickupTime)
    {
        $to = $customerInfo['email'];
        $subject = "Shipping request with ShipOnline";
        $message = "Dear {$customerInfo['name']},\n\nThank you for using ShipOnline! Your request number is {$request_number}. The cost is {$cost}. We will pick-up the item at {$pickupTime} on {$pickupDate}.";
        $headers = "From: ShipOnline <noreply@shiponline.com>\r\n";

        mail($to, $subject, $message, $headers, "-r 1234567@student.swin.edu.au");
    }
}

