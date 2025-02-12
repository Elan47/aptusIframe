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
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = bin2hex(random_bytes(8)); // Generate random password
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
$hashed_password = password_hash('user@123', PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
    if (mysqli_query($conn, $sql)) {
        sendLoginCredentials($email, $password);
        $success = "User added successfully and credentials sent to user's email.";
    } else {
        $error = "Error adding user: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM users WHERE role = 'user'";
$users = mysqli_query($conn, $sql);

$content = '
    <h2>Manage Users</h2>
    '.($success ? '<div class="alert alert-success">'.$success.'</div>' : '').'
    '.($error ? '<div class="alert alert-danger">'.$error.'</div>' : '').'

    <form method="POST" class="mb-3">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>

    <h3>User List</h3>
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                ';
                while ($user = mysqli_fetch_assoc($users)):
                $content .= '
                <tr>
                    <td>'.$user['name'].'</td>
                    <td>'.$user['email'].'</td>
                    <td>'.$user['created_at'].'</td>
                    <td>
                        <a href="edit_user.php?id='.$user['id'].'" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete_user.php?id='.$user['id'].'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>
                    </td>
                </tr>
                ';
                endwhile;
                $content .= '
            </tbody>
        </table>
    </div>
';

includeTemplate("Manage Users", $content);
?>
