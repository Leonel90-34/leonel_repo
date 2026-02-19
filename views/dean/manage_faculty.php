<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Dean.php';
Auth::requireRole('dean');

$dean = new Dean();
$message = '';
$editFaculty = null;

// Handle Add
if(isset($_POST['add'])){
    $dean->addFaculty($_POST);
    $message = "Faculty added successfully!";
}

// Handle Update
if(isset($_POST['update'])){
    $dean->updateFaculty($_POST['id'], $_POST);
    $message = "Faculty updated successfully!";
}

// Handle Delete
if(isset($_GET['delete'])){
    $dean->deleteFaculty($_GET['delete']);
    $message = "Faculty deleted successfully!";
}

// Handle Edit
if(isset($_GET['edit'])){
    $editFaculty = $dean->getFaculty($_GET['edit']);
}

// Load all faculty
$facultyList = $dean->getAllFaculty();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Faculty</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Manage Faculty</h2>
    <?php if($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <!-- Faculty Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5><?= $editFaculty ? "Edit Faculty" : "Add Faculty" ?></h5>
            <form method="POST" class="row g-2">
                <?php if($editFaculty): ?>
                    <input type="hidden" name="id" value="<?= $editFaculty['id'] ?>">
                <?php endif; ?>
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Name" required value="<?= $editFaculty['name'] ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <input type="text" name="username" class="form-control" placeholder="Username" required value="<?= $editFaculty['username'] ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <input type="password" name="password" class="form-control" placeholder="Password" <?= $editFaculty ? '' : 'required' ?>>
                </div>
                <div class="col-auto">
                    <button class="btn btn-success" name="<?= $editFaculty ? 'update' : 'add' ?>"><?= $editFaculty ? 'Update' : 'Add' ?></button>
                    <?php if($editFaculty): ?>
                        <a href="manage_faculty.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Faculty Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr><th>ID</th><th>Name</th><th>Username</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach($facultyList as $f): ?>
                    <tr>
                        <td><?= $f['id'] ?></td>
                        <td><?= $f['name'] ?></td>
                        <td><?= $f['username'] ?></td>
                        <td>
                            <a href="?edit=<?= $f['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="?delete=<?= $f['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
