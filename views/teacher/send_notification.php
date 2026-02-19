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
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Send Notification</h2>
    <?php if($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>
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
        <button class="btn btn-primary" name="send">Send Notification</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
