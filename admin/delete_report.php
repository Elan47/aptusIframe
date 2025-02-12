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

    // Delete assignments linked to this report first
    $sql = "DELETE FROM user_reports  WHERE report_id = '$id'";
    mysqli_query($conn, $sql);

    // Now delete the report
    $sql = "DELETE FROM reports WHERE id = '$id'";
    mysqli_query($conn, $sql);
}

header("Location: reports.php");
exit();
?>
