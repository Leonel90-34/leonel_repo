<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent'){
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Parent Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2>Parent Dashboard</h2>
    <div class="list-group mt-4">
        <a href="notifications.php" class="list-group-item list-group-item-action">Notifications</a>
        <a href="view_grades.php" class="list-group-item list-group-item-action">View Grades</a>
        <a href="../../logout.php" class="list-group-item list-group-item-action list-group-item-danger">Logout</a>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
