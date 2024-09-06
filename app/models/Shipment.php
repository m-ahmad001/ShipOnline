<?php
require_once __DIR__ . '/../../config/database.php';

class Shipment {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function create($user_id, $tracking_number, $origin, $destination, $weight) {
        $stmt = $this->conn->prepare("INSERT INTO shipments (user_id, tracking_number, origin, destination, weight) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssd", $user_id, $tracking_number, $origin, $destination, $weight);
        return $stmt->execute();
    }

    public function getShipmentsByUser($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM shipments WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getShipmentByTrackingNumber($tracking_number) {
        $stmt = $this->conn->prepare("SELECT * FROM shipments WHERE tracking_number = ?");
        $stmt->bind_param("s", $tracking_number);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}