<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function sendLoginCredentials($email, $password) {
    $to = $email;
    $subject = "Your APTUS Login Credentials";
    $message = "Hello,\n\nYour login credentials for APTUS are:\n";
    $message .= "Email: " . $email . "\n";
    $message .= "Password: " . $password . "\n";
    // $message .= "Please login at: http://aptus.alchemdigital.com/login\n";
    $headers = "From: admin@aptusindia.com";

    return mail($to, $subject, $message, $headers);
}

function getDashboardStats($conn) {
    $stats = array();

    // Get total users
    $sql = "SELECT COUNT(*) as total FROM users WHERE role = 'user'";
    $result = mysqli_query($conn, $sql);
    $stats['total_users'] = mysqli_fetch_assoc($result)['total'];

    // Get total reports
    $sql = "SELECT COUNT(*) as total FROM reports";
    $result = mysqli_query($conn, $sql);
    $stats['total_reports'] = mysqli_fetch_assoc($result)['total'];

    // Get total assignments
    $sql = "SELECT COUNT(*) as total FROM user_reports";
    $result = mysqli_query($conn, $sql);
    $stats['total_assignments'] = mysqli_fetch_assoc($result)['total'];

    return $stats;
}
?>
