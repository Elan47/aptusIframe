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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $report_id = mysqli_real_escape_string($conn, $_POST['report_id']);

    $sql = "INSERT INTO user_reports (user_id, report_id) VALUES ('$user_id', '$report_id')";
    if (mysqli_query($conn, $sql)) {
        $success = "Report assigned successfully";
    } else {
        $error = "Error assigning report: " . mysqli_error($conn);
    }
}

$sql = "SELECT ur.id, u.name as user_name, r.name as report_name, ur.created_at
        FROM user_reports ur
        JOIN users u ON ur.user_id = u.id
        JOIN reports r ON ur.report_id = r.id";
$assignments = mysqli_query($conn, $sql);

$sql = "SELECT id, name FROM users WHERE role = 'user'";
$users = mysqli_query($conn, $sql);

$sql = "SELECT id, name FROM reports";
$reports = mysqli_query($conn, $sql);

$content = '
    <h2>Manage Assignments</h2>
    '.($success ? '<div class="alert alert-success">'.$success.'</div>' : '').'
    '.($error ? '<div class="alert alert-danger">'.$error.'</div>' : '').'

    <form method="POST" class="mb-3">
        <div class="mb-3">
            <label for="user_id" class="form-label">User:</label>
            <select class="form-select" name="user_id" id="user_id" required>
                <option value="">Select User</option>';
                while ($user = mysqli_fetch_assoc($users)):
                $content .= '
                    <option value="'.$user['id'].'">'.$user['name'].'</option>';
                endwhile;
                $content .= '
            </select>
        </div>
        <div class="mb-3">
            <label for="report_id" class="form-label">Report:</label>
            <select class="form-select" name="report_id" id="report_id" required>
                <option value="">Select Report</option>';
                while ($report = mysqli_fetch_assoc($reports)):
                $content .= '
                    <option value="'.$report['id'].'">'.$report['name'].'</option>';
                endwhile;
                $content .= '
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Assign Report</button>
    </form>

    <h3>Assignment List</h3>
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Report</th>
                    <th>Assigned At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                ';
                while ($assignment = mysqli_fetch_assoc($assignments)):
                $content .= '
                <tr>
                    <td>'.$assignment['user_name'].'</td>
                    <td>'.$assignment['report_name'].'</td>
                    <td>'.$assignment['created_at'].'</td>
                    <td>
                        <a href="delete_assignment.php?id='.$assignment['id'].'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>
                    </td>
                </tr>
                ';
                endwhile;
                $content .= '
            </tbody>
        </table>
    </div>
';

includeTemplate("Manage Assignments", $content);
?>
