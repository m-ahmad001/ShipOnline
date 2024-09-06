<?php
require_once __DIR__ . '/../models/Shipment.php';

class ShipmentController {
    private $shipmentModel;

    public function __construct() {
        $this->shipmentModel = new Shipment();
    }

    public function createShipment($user_id, $tracking_number, $origin, $destination, $weight) {
        return $this->shipmentModel->create($user_id, $tracking_number, $origin, $destination, $weight);
    }

    public function getUserShipments($user_id) {
        return $this->shipmentModel->getShipmentsByUser($user_id);
    }

    public function trackShipment($tracking_number) {
        return $this->shipmentModel->getShipmentByTrackingNumber($tracking_number);
    }
}