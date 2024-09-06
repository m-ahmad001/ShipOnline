CREATE DATABASE shiponline;

USE shiponline;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mobileNumber VARCHAR(10) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE shipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    request_number VARCHAR(20) NOT NULL UNIQUE,
    request_date DATETIME NOT NULL,
    item_description TEXT NOT NULL,
    weight INT NOT NULL,
    pickup_address VARCHAR(255) NOT NULL,
    pickup_suburb VARCHAR(100) NOT NULL,
    pickup_date DATE NOT NULL,
    pickup_time TIME NOT NULL,
    receiver_name VARCHAR(255) NOT NULL,
    delivery_address VARCHAR(255) NOT NULL,
    delivery_suburb VARCHAR(100) NOT NULL,
    delivery_state VARCHAR(50) NOT NULL,
    
);

