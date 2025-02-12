<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/template.php';

checkLogin();

$user_id = $_SESSION['user_id'];
$sql = "SELECT r.* FROM reports r
        JOIN user_reports ur ON r.id = ur.report_id
        WHERE ur.user_id = '$user_id'";
$reports = mysqli_query($conn, $sql);

$report_content = '';
while ($report = mysqli_fetch_assoc($reports)):
    $report_content .= '
        <div class="report mb-3">
            <h3>'.$report['name'].'</h3>
            <div class="ratio ratio-16x9">
                <iframe src="'.$report['iframe_url'].'" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    ';
endwhile;

$content = '
    <h2>My Reports</h2>
    <div class="reports">
        '.$report_content.'
    </div>
';

includeTemplate("User Dashboard", $content);
?>
