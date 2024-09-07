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
        $query = "SELECT r.customer_id, r.request_number, r.item_description, r.weight, 
                         r.pickup_suburb, r.pickup_date, r.delivery_suburb, r.delivery_state, r.total_cost
                  FROM shipments r
                  WHERE DATE(r.request_date) = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $date);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getRequestsByPickupDate($date)
    {
        $query = "SELECT r.customer_id, c.name, c.email,c.mobileNumber, r.request_number, 
                         r.item_description, r.weight, r.pickup_address, r.pickup_suburb, r.pickup_time, 
                         r.delivery_suburb, r.delivery_state
                  FROM shipments r
                  JOIN users c ON r.customer_id = c.id
                  WHERE DATE(r.pickup_date) = ?
                  ORDER BY r.pickup_suburb, r.delivery_state, r.delivery_suburb";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $date);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createShipment($data)
    {
        $sql = "INSERT INTO shipments (customer_id, request_number, request_date, item_description, weight, pickup_address, pickup_suburb, pickup_date, pickup_time, receiver_name, delivery_address, delivery_suburb, delivery_state) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $total_cost = $this->calculateCost($data['weight']);
        $data['total_cost'] = $total_cost;

        if ($stmt) {
            $stmt->bind_param(
                "isssdssssssss",
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

    public function getCustomerInfo($customer_id)
    {
        $sql = "SELECT name, email FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


}