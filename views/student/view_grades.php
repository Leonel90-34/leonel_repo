<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Student.php';
Auth::requireRole('student');

$student = new Student();
$grades = $student->getGrades();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Grades</title>
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
    <a href="notifications.php"><i class="fas fa-bell me-2"></i> Notifications</a>
    <a href="view_grades.php" class="active"><i class="fas fa-chart-bar me-2"></i> View Grades</a>
    <a href="../../logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    <hr class="text-secondary">
</div>

<!-- Main Content -->
<div class="content">

    <?php include '../includes/header.php'; ?>

    <div class="container-fluid">
        <h2 class="fw-bold"><i class="fas fa-chart-bar me-2"></i> My Grades</h2>

        <?php if($grades): ?>
            <div class="table-responsive shadow-sm border-0 mt-3">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Subject</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($grades as $g): ?>
                            <tr>
                                <td><?= $g['subject'] ?></td>
                                <td><?= $g['grade'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-3">No grades available.</div>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>

</div>

</body>
</html>
