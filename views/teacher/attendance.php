<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Teacher.php';
Auth::requireRole('teacher');

$teacher = new Teacher();
$message = '';

// Set selected date
$selectedDate = $_POST['date'] ?? date('Y-m-d');

// Handle attendance submission
if(isset($_POST['submit'])){
    foreach($_POST['attendance'] as $student_id => $status){
        $teacher->submitAttendance($student_id, $_POST['date'], $status);
    }
    $message = "Attendance saved successfully!";
}

// Get all students
$students = $teacher->getStudents();

// Get existing attendance for the selected date
$existingAttendance = [];
$attendanceRecords = $teacher->getAttendance($selectedDate);
foreach($attendanceRecords as $a){
    $existingAttendance[$a['student_id']] = $a['status'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Submit Attendance</title>
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
    <a href="attendance.php" class="active"><i class="fas fa-calendar-check me-2"></i> Submit Attendance</a>
    <a href="manage_test.php"><i class="fas fa-book me-2"></i> Manage Test</a>
    <a href="send_notification.php"><i class="fas fa-envelope me-2"></i> Send Message</a>
    <hr class="text-secondary">
</div>

<!-- Main Content -->
<div class="content">

    <?php include '../includes/header.php'; ?>

    <div class="container-fluid">
        <h2 class="fw-bold">Submit Attendance</h2>
        <?php if($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <!-- Select Date -->
        <form method="POST" class="mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <label>Date:</label>
                    <input type="date" name="date" class="form-control" value="<?= $selectedDate ?>" onchange="this.form.submit()">
                </div>
            </div>
        </form>

        <!-- Attendance Table -->
        <form method="POST">
            <input type="hidden" name="date" value="<?= $selectedDate ?>">
            <div class="table-responsive shadow-sm border-0">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Student</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($students as $s): ?>
                            <tr>
                                <td><?= $s['name'] ?></td>
                                <td>
                                    <select name="attendance[<?= $s['id'] ?>]" class="form-select">
                                        <option value="present" <?= (isset($existingAttendance[$s['id']]) && $existingAttendance[$s['id']]=='present')?'selected':'' ?>>Present</option>
                                        <option value="absent" <?= (isset($existingAttendance[$s['id']]) && $existingAttendance[$s['id']]=='absent')?'selected':'' ?>>Absent</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-success mt-2" name="submit"><i class="fas fa-save me-1"></i> Submit Attendance</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>

</div>

</body>
</html>
