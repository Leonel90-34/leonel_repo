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
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Manage Tests</h2>
    <?php if($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <!-- Test Form -->
    <div class="card mb-4">
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
                    <button class="btn btn-success" name="<?= $editTest ? 'update' : 'add' ?>"><?= $editTest ? 'Update' : 'Add' ?></button>
                    <?php if($editTest): ?>
                        <a href="manage_tests.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Tests Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr><th>ID</th><th>Subject</th><th>Title</th><th>Max Score</th><th>Date</th><th>Actions</th></tr>
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
                            <a href="?edit=<?= $t['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="?delete=<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
