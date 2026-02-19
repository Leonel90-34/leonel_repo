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
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Submit Attendance</h2>

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
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr><th>Student</th><th>Status</th></tr>
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
        <button class="btn btn-success" name="submit">Submit Attendance</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
