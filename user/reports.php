<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/template.php';

checkLogin();

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Query to fetch only the reports related to the current user
$sql = "
    SELECT r.id, r.name, r.iframe_url 
    FROM reports r
    JOIN user_reports ur ON r.id = ur.report_id
    WHERE ur.user_id = '$user_id'
";
$reports = mysqli_query($conn, $sql);

$content = '
    <h2>Reports</h2>

    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                ';
                while ($report = mysqli_fetch_assoc($reports)):
                $content .= '
                <tr>
                    <td>'.$report['name'].'</td>
                    <td>
                        <a href="view_report.php?id='.$report['id'].'" class="btn btn-sm btn-primary">View Report</a>
                    </td>
                </tr>
                ';
                endwhile;
                $content .= '
            </tbody>
        </table>
    </div>
';

includeTemplate("Reports", $content);
?>
