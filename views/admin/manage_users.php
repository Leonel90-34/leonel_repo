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

// Handle Edit User Form
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
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Manage Users</h2>

    <?php if($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <!-- Search -->
    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="search" class="form-control" placeholder="Search by name or username" value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- User Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5><?= $editUser ? "Edit User" : "Add User" ?></h5>
            <form method="POST">
                <?php if($editUser): ?>
                    <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
                <?php endif; ?>
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" name="name" class="form-control" placeholder="Name" required value="<?= $editUser['name'] ?? '' ?>">
                    </div>
                    <div class="col">
                        <input type="text" name="username" class="form-control" placeholder="Username" required value="<?= $editUser['username'] ?? '' ?>">
                    </div>
                    <div class="col">
                        <input type="password" name="password" class="form-control" placeholder="Password" <?= $editUser ? '' : 'required' ?>>
                    </div>
                    <div class="col">
                        <select name="role" class="form-select" required>
                            <option value="">Select Role</option>
                            <?php foreach(['admin','dean','teacher','parent','student'] as $role): ?>
                                <option value="<?= $role ?>" <?= ($editUser['role']??'')==$role?'selected':'' ?>><?= ucfirst($role) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success" name="<?= $editUser ? 'update' : 'add' ?>"><?= $editUser ? 'Update' : 'Add' ?></button>
                        <?php if($editUser): ?>
                            <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr><th>ID</th><th>Name</th><th>Username</th><th>Role</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= $u['name'] ?></td>
                        <td><?= $u['username'] ?></td>
                        <td><?= $u['role'] ?></td>
                        <td>
                            <a href="?edit=<?= $u['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="?delete=<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
