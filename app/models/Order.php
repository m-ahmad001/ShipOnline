<?php
require_once __DIR__ . '/../../config/database.php';

class Order {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function create($customer_id, $total_amount) {
        $stmt = $this->conn->prepare("INSERT INTO orders (customer_id, total_amount) VALUES (?, ?)");
        $stmt->bind_param("id", $customer_id, $total_amount);
        return $stmt->execute() ? $this->conn->insert_id : false;
    }

    public function addOrderItem($order_id, $product_id, $quantity, $price) {
        $stmt = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        return $stmt->execute();
    }

    public function getOrdersByCustomerId($customer_id) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}