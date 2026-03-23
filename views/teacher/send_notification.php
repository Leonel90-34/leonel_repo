<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Notification.php';
require_once '../../classes/Teacher.php';
Auth::requireRole('teacher');

$teacher = new Teacher();
$notification = new Notification();

// Get all students (so teacher can select)
$students = $teacher->getAllStudents();

$message = '';
if(isset($_POST['send'])){
    $student_id = $_POST['student_id'];
    $msg = $_POST['message'];
    if($notification->send($student_id, $msg)){
        $message = "Notification sent successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Send Notification</title>
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
    <a href="send_notification.php" class="active"><i class="fas fa-envelope me-2"></i> Send Message</a>
    <hr class="text-secondary">
</div>

<!-- Main Content -->
<div class="content">

    <?php include '../includes/header.php'; ?>

    <div class="container-fluid">
        <h2 class="fw-bold">Send Notification</h2>
        <?php if($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" class="mb-3">
                    <div class="mb-3">
                        <label>Student</label>
                        <select name="student_id" class="form-select" required>
                            <?php foreach($students as $s): ?>
                                <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Message</label>
                        <textarea name="message" class="form-control" required></textarea>
                    </div>
                    <button class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Send Notification</button>
                </form>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

</div>

</body>
</html>
