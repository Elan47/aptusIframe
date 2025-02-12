<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/template.php';

checkLogin();
if (!isAdmin()) {
    header("Location: /user/dashboard.php");
    exit();
}

$stats = getDashboardStats($conn);

$content = '
    <h2>Admin Dashboard</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">'.$stats['total_users'].'</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Reports</h5>
                    <p class="card-text">'.$stats['total_reports'].'</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Assignments</h5>
                    <p class="card-text">'.$stats['total_assignments'].'</p>
                </div>
            </div>
        </div>
    </div>
';

includeTemplate("Admin Dashboard", $content);
?>
