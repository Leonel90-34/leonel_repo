<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Teacher.php';
Auth::requireRole('teacher');

$teacher = new Teacher();
$message = '';
$editTest = null;

// Handle Add Test
if(isset($_POST['add'])){
    $teacher->addTest($_POST);
    $message = "Test added successfully!";
}

// Handle Update Test
if(isset($_POST['update'])){
    $teacher->updateTest($_POST['id'], $_POST);
    $message = "Test updated successfully!";
}

// Handle Delete Test
if(isset($_GET['delete'])){
    $teacher->deleteTest($_GET['delete']);
    $message = "Test deleted successfully!";
}

// Handle Edit Form
if(isset($_GET['edit'])){
    $editTest = $teacher->getTest($_GET['edit']);
}

// Load all tests
$tests = $teacher->getTests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Tests</title>
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
    <a href="manage_test.php" class="active"><i class="fas fa-book me-2"></i> Manage Test</a>
    <a href="send_notification.php"><i class="fas fa-envelope me-2"></i> Send Message</a>
    <hr class="text-secondary">
</div>

<!-- Main Content -->
<div class="content">

    <?php include '../includes/header.php'; ?>

    <div class="container-fluid">
        <h2 class="fw-bold">Manage Tests</h2>
        <?php if($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <!-- Test Form -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <h5><?= $editTest ? "Edit Test" : "Add Test" ?></h5>
                <form method="POST" class="row g-2">
                    <?php if($editTest): ?>
                        <input type="hidden" name="id" value="<?= $editTest['id'] ?>">
                    <?php endif; ?>
                    <div class="col-md-3">
                        <input type="text" name="subject" class="form-control" placeholder="Subject" required value="<?= $editTest['subject'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="title" class="form-control" placeholder="Test Title" required value="<?= $editTest['title'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="max_score" class="form-control" placeholder="Max Score" required value="<?= $editTest['max_score'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date" class="form-control" required value="<?= $editTest['date'] ?? date('Y-m-d') ?>">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success" name="<?= $editTest ? 'update' : 'add' ?>"><i class="fas fa-save me-1"></i> <?= $editTest ? 'Update' : 'Add' ?></button>
                        <?php if($editTest): ?>
                            <a href="manage_test.php" class="btn btn-secondary">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tests Table -->
        <div class="table-responsive shadow-sm border-0">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Title</th>
                        <th>Max Score</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tests as $t): ?>
                        <tr>
                            <td><?= $t['id'] ?></td>
                            <td><?= $t['subject'] ?></td>
                            <td><?= $t['title'] ?></td>
                            <td><?= $t['max_score'] ?></td>
                            <td><?= $t['date'] ?></td>
                            <td>
                                <a href="?edit=<?= $t['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit me-1"></i> Edit</a>
                                <a href="?delete=<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash me-1"></i> Delete</a>
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
