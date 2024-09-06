<?php
require_once __DIR__ . '/../../config/database.php';

class Shipment
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }


    public function getRequestsByRequestDate($date)
    {
        $stmt = $this->conn->prepare("SELECT * 
                                     FROM shipments WHERE request_date = ?");
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getRequestsByPickupDate($date)
    {
        $stmt = $this->conn->prepare("SELECT * 
                                     FROM shipments WHERE pickup_date = ?");
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createShipment($data)
    {
        $sql = "INSERT INTO shipments (customer_id, request_number, request_date, item_description, weight, pickup_address, pickup_suburb, pickup_date, pickup_time, receiver_name, delivery_address, delivery_suburb, delivery_state) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param(
                "isssdssssssss", // Updated type definition string
                $data['customer_id'],
                $data['request_number'],
                $data['request_date'],
                $data['item_description'],
                $data['weight'],
                $data['pickup_address'],
                $data['pickup_suburb'],
                $data['pickup_date'],
                $data['pickup_time'],
                $data['receiver_name'],
                $data['delivery_address'],
                $data['delivery_suburb'],
                $data['delivery_state']
            );

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function generateRequestNumber()
    {
        // Generate a unique request number
        $prefix = 'REQ-';
        $timestamp = time();
        $random = mt_rand(1000, 9999);
        return $prefix . $timestamp . '-' . $random;
    }

    public function calculateCost($weight)
    {
        // Calculate the cost based on the weight
        $base_cost = 10;
        $cost_per_kg = 2;
        return $base_cost + ($weight * $cost_per_kg);
    }

    public function validateInput($data)
    {
        // Validate the input data
        $errors = [];
        if (empty($data['item_description'])) {
            $errors[] = 'Item description is required';
        }
        return $errors;
    }

    // ... rest of the model code ...
}