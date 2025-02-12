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
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $iframe_url = mysqli_real_escape_string($conn, $_POST['iframe_url']);

    $sql = "INSERT INTO reports (name, iframe_url) VALUES ('$name', '$iframe_url')";
    if (mysqli_query($conn, $sql)) {
        $success = "Report added successfully";
    } else {
        $error = "Error adding report: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM reports";
$reports = mysqli_query($conn, $sql);

$content = '
    <h2>Manage Reports</h2>
    '.($success ? '<div class="alert alert-success">'.$success.'</div>' : '').'
    '.($error ? '<div class="alert alert-danger">'.$error.'</div>' : '').'

    <form method="POST" class="mb-3">
        <div class="mb-3">
            <label for="name" class="form-label">Report Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="iframe_url" class="form-label">iFrame URL:</label>
            <input type="text" class="form-control" id="iframe_url" name="iframe_url" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Report</button>
    </form>

    <h3>Report List</h3>
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>iFrame URL</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                ';
                while ($report = mysqli_fetch_assoc($reports)):
                $content .= '
                <tr>
                    <td>'.$report['name'].'</td>
                    <td><iframe src="'.$report['iframe_url'].'" frameborder="0" allowfullscreen></iframe></td>   
                    <td>'.$report['created_at'].'</td>
                    <td>
                        <a href="edit_report.php?id='.$report['id'].'" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete_report.php?id='.$report['id'].'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>
                    </td>
                </tr>
                ';
                endwhile;
                $content .= '
            </tbody>
        </table>
    </div>
';

includeTemplate("Manage Reports", $content);
?>
