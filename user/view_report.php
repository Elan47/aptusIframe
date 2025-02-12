<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/template.php';

checkLogin();

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Check if the report ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: reports.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Query to check if the report belongs to the logged-in user
$sql = "
    SELECT r.id, r.name, r.iframe_url
    FROM reports r
    JOIN user_reports ur ON r.id = ur.report_id
    WHERE ur.user_id = '$user_id' AND r.id = '$id'
";
$result = mysqli_query($conn, $sql);
$report = mysqli_fetch_assoc($result);

if (!$report) {
    // If the report does not belong to the user, redirect to the reports list
    header("Location: reports.php");
    exit();
}

$content = '
    <h2>'.$report['name'].'</h2>
    <div class="mb-3">
        <iframe src="'.$report['iframe_url'].'" width="100%" height="600px" frameborder="0" allowfullscreen></iframe>
    </div>
    <a href="reports.php" class="btn btn-secondary">Back to Reports</a>
';

includeTemplate("View Report", $content);
?>
