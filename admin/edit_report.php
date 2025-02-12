<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/template.php';

checkLogin();
if (!isAdmin()) {
    header("Location: /user/dashboard.php");
    exit();
}

$success = '';
$error = '';
if (isset($_GET['id'])) {
    $report_id = mysqli_real_escape_string($conn, $_GET['id']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $iframe_url = mysqli_real_escape_string($conn, $_POST['iframe_url']);

        $sql = "UPDATE reports SET name='$name', iframe_url='$iframe_url' WHERE id='$report_id'";
        if (mysqli_query($conn, $sql)) {
            $success = "Report updated successfully";
        } else {
            $error = "Error updating report: " . mysqli_error($conn);
        }
    }

    $sql = "SELECT * FROM reports WHERE id = '$report_id'";
    $result = mysqli_query($conn, $sql);
    $report = mysqli_fetch_assoc($result);
    if (!$report) {
        header("Location: reports.php");
        exit();
    }
} else {
    header("Location: reports.php");
    exit();
}

$content = '
    <h2>Edit Report</h2>
    <a href="reports.php" class="btn btn-secondary mb-3">Back to Report List</a>
    '.($success ? '<div class="alert alert-success">'.$success.'</div>' : '').'
    '.($error ? '<div class="alert alert-danger">'.$error.'</div>' : '').'

    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Report Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="'.$report['name'].'" required>
        </div>
        <div class="mb-3">
            <label for="iframe_url" class="form-label">iFrame URL:</label>
            <input type="text" class="form-control" id="iframe_url" name="iframe_url" value="'.$report['iframe_url'].'" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Report</button>
    </form>
';

includeTemplate("Edit Report", $content);
?>
