<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/template.php';

checkLogin();

$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if (password_verify($current_password, $user['password'])) {
        $updates = array();
        $updates[] = "name = '$name'";
        $updates[] = "email = '$email'";

        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $updates[] = "password = '$hashed_password'";
        }

        $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = '$user_id'";
        if (mysqli_query($conn, $sql)) {
            $success = "Profile updated successfully";
        } else {
            $error = "Error updating profile: " . mysqli_error($conn);
        }
    } else {
        $error = "Current password is incorrect";
    }
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$content = '
    <h2>Profile</h2>
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
            <label for="current_password" class="form-label">Current Password:</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">New Password (leave blank to keep current):</label>
            <input type="password" class="form-control" id="new_password" name="new_password">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
';

includeTemplate("Profile", $content);
?>
