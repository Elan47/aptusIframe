<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

checkLogin();
if (!isAdmin()) {
    header("Location: /user/dashboard.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "DELETE FROM users WHERE id = '$id' AND role = 'user'";
    mysqli_query($conn, $sql);
}

header("Location: users.php");
exit();
?>
