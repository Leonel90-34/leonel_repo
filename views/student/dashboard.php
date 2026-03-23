<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
    body {
        overflow-x: hidden;
    }
    .sidebar {
        height: 100vh;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #212529;
        padding-top: 20px;
    }
    .sidebar a {
        color: #adb5bd;
        padding: 12px 20px;
        display: block;
        text-decoration: none;
        transition: 0.3s;
    }
    .sidebar a:hover {
        background-color: #343a40;
        color: #fff;
    }
    .sidebar .active {
        background-color: #0d6efd;
        color: #fff;
    }
    .content {
        margin-left: 250px;
        padding: 20px;
    }
</style>
</head>

<body class="bg-light">

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-white text-center mb-4">Student Panel</h4>
    <a href="notifications.php" class="active"><i class="fas fa-bell me-2"></i> Notifications</a>
    <a href="view_grades.php"><i class="fas fa-chart-bar me-2"></i> View Grades</a>
    <a href="../../logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    <hr class="text-secondary">
</div>

<!-- Main Content -->
<div class="content">

    <?php include '../includes/header.php'; ?>

    <div class="container-fluid">
        <h2 class="fw-bold">Student Dashboard</h2>
        <p class="text-muted">Welcome! Select an option from the sidebar.</p>

        <div class="row g-4 mt-3">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5><i class="fas fa-bell me-2"></i> Notifications</h5>
                        <p class="text-muted small">View your notifications</p>
                        <a href="notifications.php" class="btn btn-primary btn-sm">Go</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5><i class="fas fa-chart-bar me-2"></i> Grades</h5>
                        <p class="text-muted small">Check your grades</p>
                        <a href="view_grades.php" class="btn btn-primary btn-sm">Go</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

</div>

</body>
</html>
