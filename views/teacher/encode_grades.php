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
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Encode Grades</h2>
    <?php if($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <!-- Grades Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr><th>Student</th><th>Subject</th><th>Grade</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php foreach($students as $s):
                    $grades = $teacher->getGrades($s['id']);
                ?>
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
                            <button class="btn btn-success btn-sm" name="submit">Save</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
