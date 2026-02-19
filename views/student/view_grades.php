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
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>My Grades</h2>

    <?php if($grades): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr><th>Subject</th><th>Grade</th></tr>
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
        <p>No grades available.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
