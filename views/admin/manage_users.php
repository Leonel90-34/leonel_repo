<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Admin.php';
Auth::requireRole('admin');

$admin = new Admin();
$message = '';
$editUser = null;

// Handle Create / Add User
if(isset($_POST['add'])){
    $admin->addUser($_POST);
    $message = "User added successfully!";
}

// Handle Update User
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $admin->updateUser($id, $_POST);
    $message = "User updated successfully!";
}

// Handle Delete User
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $admin->deleteUser($id);
    $message = "User deleted successfully!";
}

// Handle Edit User
if(isset($_GET['edit'])){
    $editUser = $admin->getUser($_GET['edit']);
}

// Handle Search
$search = '';
if(isset($_GET['search'])){
    $search = trim($_GET['search']);
    $users = $admin->searchUsers($search);
} else {
    $users = $admin->getAllUsers();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users</title>
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
    <h4 class="text-white text-center mb-4">Admin Panel</h4>

    <a href="manage_users.php"><i class="fas fa-users me-2"></i> Manage Users</a>
    <a href="assign_parent.php"><i class="fas fa-user-friends me-2"></i> Assign Parent</a>
    <a href="system_settings.php"><i class="fas fa-cogs me-2"></i> System Settings</a>
    <a href="reports.php"><i class="fas fa-chart-line me-2"></i> View Reports</a>

    <hr class="text-secondary">
</div>

<!-- Main Content -->
<div class="content">

    <!-- Navbar -->
    <?php include '../includes/header.php'; ?>

    <div class="container-fluid mt-3">

        <!-- Page Title -->
        <div class="mb-4">
            <h3 class="fw-bold">Manage Users</h3>
            <p class="text-muted">Add, edit, and manage system users</p>
        </div>

        <?php if($message): ?>
            <div class="alert alert-success shadow-sm"><?= $message ?></div>
        <?php endif; ?>

        <!-- Search Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control"
                            placeholder="Search by name or username"
                            value="<?= htmlspecialchars($search) ?>">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary">Search</button>
                        <a href="manage_users.php" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- User Form -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3"><?= $editUser ? "Edit User" : "Add User" ?></h5>

                <form method="POST">
                    <?php if($editUser): ?>
                        <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
                    <?php endif; ?>

                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="name" class="form-control"
                                placeholder="Name" required
                                value="<?= $editUser['name'] ?? '' ?>">
                        </div>

                        <div class="col-md-3">
                            <input type="text" name="username" class="form-control"
                                placeholder="Username" required
                                value="<?= $editUser['username'] ?? '' ?>">
                        </div>

                        <div class="col-md-2">
                            <input type="password" name="password" class="form-control"
                                placeholder="Password" <?= $editUser ? '' : 'required' ?>>
                        </div>

                        <div class="col-md-2">
                            <select name="role" class="form-select" required>
                                <option value="">Role</option>
                                <?php foreach(['admin','dean','teacher','parent','student'] as $role): ?>
                                    <option value="<?= $role ?>"
                                        <?= ($editUser['role']??'')==$role?'selected':'' ?>>
                                        <?= ucfirst($role) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2 d-flex gap-2">
                            <button class="btn btn-success w-100"
                                name="<?= $editUser ? 'update' : 'add' ?>">
                                <?= $editUser ? 'Update' : 'Add' ?>
                            </button>

                            <?php if($editUser): ?>
                                <a href="manage_users.php" class="btn btn-secondary w-100">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($users as $u): ?>
                            <tr>
                                <td><?= $u['id'] ?></td>
                                <td><?= $u['name'] ?></td>
                                <td><?= $u['username'] ?></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= ucfirst($u['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="?edit=<?= $u['id'] ?>"
                                       class="btn btn-sm btn-warning">Edit</a>

                                    <a href="?delete=<?= $u['id'] ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure?')">
                                       Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>
        </div>

    </div>

    <?php include '../includes/footer.php'; ?>

</div>

</body>
</html>
