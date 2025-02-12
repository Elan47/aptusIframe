<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/template.php';

checkLogin();
if (!isAdmin()) {
    header("Location: /user/dashboard.php");
    exit();
}

$error = '';
$success = '';
if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        $sql = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id='$user_id'";
        if (mysqli_query($conn, $sql)) {
            $success = "User updated successfully";
        } else {
            $error = "Error updating user: " . mysqli_error($conn);
        }
    }

    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
        header("Location: users.php");
        exit();
    }
} else {
    header("Location: users.php");
    exit();
}

$content = '
    <h2>Edit User</h2>
    <a href="users.php" class="btn btn-secondary mb-3">Back to User List</a>
    '.($success ? '<div class="alert alert-success">'.$success.'</div>' : '').'
    '.($error ? '<div class="alert alert-danger">'.$error.'</div>' : '').'

    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="'.$user['name'].'" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="'.$user['email'].'" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role:</label>
            <select class="form-select" id="role" name="role">
                <option value="user" '.($user['role'] == 'user' ? 'selected' : '').'>User</option>
                <option value="admin" '.($user['role'] == 'admin' ? 'selected' : '').'>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
';

includeTemplate("Edit User", $content);
?>
