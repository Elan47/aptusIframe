<?php
function includeTemplate($title, $content) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - APTUS</title>

    <!-- Bootstrap CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- DataTables CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        body { padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">APTUS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <?php if (isAdmin()): ?>
                        <li class="nav-item"><a class="nav-link" href="../admin/home.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="../admin/users.php">Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="../admin/reports.php">Reports</a></li>
                        <li class="nav-item"><a class="nav-link" href="../admin/assignments.php">Assignments</a></li>
                        <li class="nav-item"><a class="nav-link" href="../admin/profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                        <?php elseif (isUser()): ?>
                        <!-- <li class="nav-item"><a class="nav-link" href="./dashboard.php">Dashboard</a></li> -->
                        <li class="nav-item"><a class="nav-link" href="./reports.php">Reports</a></li>
                        <li class="nav-item"><a class="nav-link" href="./profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                        <?php else: ?>
                        
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php echo $content; ?>
    </div>

    <!-- jQuery (CDN) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Bundle JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS (CDN) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
</body>
</html>
<?php
}
?>
