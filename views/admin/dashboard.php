<?php
session_start();
require_once '../../classes/Auth.php';

Auth::requireRole('admin');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2>Admin Dashboard</h2>
    <div class="list-group mt-4">
        <a href="manage_users.php" class="list-group-item list-group-item-action">Manage Users</a>
        <a href="assign_parent.php" class="list-group-item list-group-item-action">Assign Parent</a>
        <a href="system_settings.php" class="list-group-item list-group-item-action">System Settings</a>
        <a href="reports.php" class="list-group-item list-group-item-action">View Reports</a>
        <a href="../../logout.php" class="list-group-item list-group-item-action list-group-item-danger">Logout</a>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>