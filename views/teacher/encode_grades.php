<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Teacher.php';
Auth::requireRole('teacher');

$teacher = new Teacher();
$message = '';

// Handle Add/Update Grade
if(isset($_POST['submit'])){
    $teacher->addOrUpdateGrade($_POST['student_id'], $_POST['subject'], $_POST['grade']);
    $message = "Grade saved successfully!";
}

// Get all students
$students = $teacher->getStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Encode Grades</title>
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
    <a href="encode_grades.php" class="active"><i class="fas fa-pen me-2"></i> Encode Grades</a>
    <a href="attendance.php"><i class="fas fa-calendar-check me-2"></i> Submit Attendance</a>
    <a href="manage_test.php"><i class="fas fa-book me-2"></i> Manage Test</a>
    <a href="send_notification.php"><i class="fas fa-envelope me-2"></i> Send Message</a>
    <hr class="text-secondary">
</div>

<!-- Main Content -->
<div class="content">

    <?php include '../includes/header.php'; ?>

    <div class="container-fluid">
        <h2 class="fw-bold">Encode Grades</h2>
        <?php if($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <!-- Grades Table -->
        <div class="table-responsive shadow-sm border-0">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($students as $s): ?>
                    <tr>
                        <td><?= $s['name'] ?></td>
                        <td>
                            <form method="POST" class="d-flex gap-2">
                                <input type="hidden" name="student_id" value="<?= $s['id'] ?>">
                                <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                        </td>
                        <td>
                                <input type="text" name="grade" class="form-control" placeholder="Grade" required>
                        </td>
                        <td>
                                <button class="btn btn-success btn-sm"><i class="fas fa-save me-1"></i> Save</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

</div>

</body>
</html>
