<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register($name, $email, $password, $mobileNumber)
    {

        try {
            return $this->userModel->register($name, $email, $password, $mobileNumber);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function login($mobileNumber, $password)
    {
        return $this->userModel->login($mobileNumber, $password);
    }
}