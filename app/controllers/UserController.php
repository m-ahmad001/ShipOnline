<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register($username, $email, $password) {
        return $this->userModel->register($username, $email, $password);
    }

    public function login($username, $password) {
        return $this->userModel->login($username, $password);
    }
}