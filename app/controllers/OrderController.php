<?php
require_once __DIR__ . '/../models/Order.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }

    public function createOrder($customer_id, $total_amount, $items) {
        $order_id = $this->orderModel->create($customer_id, $total_amount);
        if ($order_id) {
            foreach ($items as $item) {
                $this->orderModel->addOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price']);
            }
            return $order_id;
        }
        return false;
    }

    public function getCustomerOrders($customer_id) {
        return $this->orderModel->getOrdersByCustomerId($customer_id);
    }
}