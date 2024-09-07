<?php
require_once __DIR__ . '/../../config/database.php';

class User
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function register($name, $email, $password, $mobileNumber)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, mobileNumber) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $mobileNumber);

        try {
            return $stmt->execute();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function login($mobileNumber, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, mobileNumber, password FROM users WHERE mobileNumber = ?");
        $stmt->bind_param("s", $mobileNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }
}