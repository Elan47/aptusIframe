<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'adminer');
define('DB_PASS', 'adminer');
define('DB_NAME', 'aptus_db');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$db_selected = mysqli_select_db($conn, DB_NAME);
if (!$db_selected) {
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
    if (mysqli_query($conn, $sql)) {
        $db_selected = mysqli_select_db($conn, DB_NAME);
    } else {
        die("Error creating database: " . mysqli_error($conn));
    }
}
?>
