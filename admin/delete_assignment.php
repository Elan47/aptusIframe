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

    // Correct table name (previously used 'user_reports' incorrectly)
    $sql = "DELETE FROM user_reports  WHERE id = '$id'";
    mysqli_query($conn, $sql);
}

header("Location: assignments.php");
exit();
?>
