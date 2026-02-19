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
</head>

<body class="bg-light">
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <h2>Teacher Dashboard</h2>
        <div class="list-group mt-4">
            <a href="encode_grades.php" class="list-group-item list-group-item-action">Encode Grades</a>
            <a href="attendance.php" class="list-group-item list-group-item-action">Submit Attendance</a>
            <a href="manage_test.php" class="list-group-item list-group-item-action">Manage Test</a>
            <a href="send_notification.php" class="list-group-item list-group-item-action">Send Message</a>
            <a href="../../logout.php" class="list-group-item list-group-item-action list-group-item-danger">Logout</a>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>

</html>