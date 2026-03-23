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
    <h4 class="text-white text-center mb-4">Dean Panel</h4>
    <a href="manage_faculty.php" class="active"><i class="fas fa-chalkboard-teacher me-2"></i> Manage Faculty</a>
    <hr class="text-secondary">
</div>

<!-- Main Content -->
<div class="content">

    <?php include '../includes/header.php'; ?>

    <div class="container-fluid">
        <h2 class="fw-bold">Manage Faculty</h2>
        <?php if($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <!-- Faculty Form -->
        <div class="card mb-4 shadow-sm border-0">
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
            <table class="table table-striped table-bordered shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($facultyList as $f): ?>
                        <tr>
                            <td><?= $f['id'] ?></td>
                            <td><?= $f['name'] ?></td>
                            <td><?= $f['username'] ?></td>
                            <td>
                                <a href="?edit=<?= $f['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit me-1"></i> Edit</a>
                                <a href="?delete=<?= $f['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash me-1"></i> Delete</a>
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
