<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
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
        <h4 class="text-white text-center mb-4">Teacher Panel</h4>
        <a href="encode_grades.php"><i class="fas fa-pen me-2"></i> Encode Grades</a>
        <a href="attendance.php"><i class="fas fa-calendar-check me-2"></i> Submit Attendance</a>
        <a href="manage_test.php"><i class="fas fa-book me-2"></i> Manage Test</a>
        <a href="send_notification.php"><i class="fas fa-envelope me-2"></i> Send Message</a>
        <hr class="text-secondary">
    </div>

    <!-- Main Content -->
    <div class="content">

        <?php include '../includes/header.php'; ?>

        <div class="container-fluid">
            <h2 class="fw-bold">Teacher Dashboard</h2>
            <p class="text-muted">Welcome! Select an option from the sidebar.</p>

            <!-- Optional Dashboard Cards -->
            <div class="row g-4 mt-3">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5>Encode Grades</h5>
                            <p class="text-muted small">Submit student grades</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5>Attendance</h5>
                            <p class="text-muted small">Submit class attendance</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5>Tests</h5>
                            <p class="text-muted small">Manage tests and exams</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../includes/footer.php'; ?>

    </div>

</body>

</html>
