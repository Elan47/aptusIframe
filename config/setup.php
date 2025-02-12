<?php
require_once 'database.php';

// Users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql);

// Reports table
$sql = "CREATE TABLE IF NOT EXISTS reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    iframe_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql);

// User Reports table (for assignments)
$sql = "CREATE TABLE IF NOT EXISTS user_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    report_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE
)";
mysqli_query($conn, $sql);

// Insert default admin user
$admin_password = password_hash('admin@123', PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO users (name, email, password, role)
        VALUES ('Admin', 'admin@aptusindia.com', '$admin_password', 'admin')";
mysqli_query($conn, $sql);
?>
