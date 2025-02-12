<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/template.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin/home.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit();
        }
    }
    $error = "Invalid credentials";
}

$content = '
    <h2>Login</h2>
    '.($error ? '<div class="alert alert-danger">'.$error.'</div>' : '').'
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
';

includeTemplate("Login", $content);
?>
