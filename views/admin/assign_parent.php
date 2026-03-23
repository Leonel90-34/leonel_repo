<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Admin.php';
Auth::requireRole('admin');

$admin = new Admin();
$message = '';

// Handle assignment form submission
if(isset($_POST['assign'])){
    $admin->assignParentToStudents($_POST['parent_id'], $_POST['students'] ?? []);
    $message = "Parent assigned to students successfully!";
}

// Load all parents
$parents = $admin->getParents();

// Selected parent
$selectedParent = $_GET['parent'] ?? ($parents[0]['id'] ?? null);
$childrenOfParent = $selectedParent ? $admin->getChildrenOfParent($selectedParent) : [];

// Load all students
$allStudents = $admin->getStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Assign Parent to Students</title>
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

    <!-- Top Navbar -->
    <?php include '../includes/header.php'; ?>

    <div class="container-fluid mt-3">

        <!-- Page Title -->
        <div class="mb-4">
            <h3 class="fw-bold">Assign Parent to Students</h3>
            <p class="text-muted">Link students to a selected parent</p>
        </div>

        <?php if($message): ?>
            <div class="alert alert-success shadow-sm"><?= $message ?></div>
        <?php endif; ?>

        <!-- Parent Selection Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET">
                    <label class="form-label fw-semibold">Select Parent</label>
                    <select name="parent" class="form-select" onchange="this.form.submit()">
                        <?php foreach($parents as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= $p['id']==$selectedParent?'selected':'' ?>>
                                <?= $p['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>

        <!-- Students Assignment -->
        <?php if($selectedParent): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form method="POST">
                    <input type="hidden" name="parent_id" value="<?= $selectedParent ?>">

                    <label class="form-label fw-semibold">Select Students</label>

                    <div class="row">
                        <?php foreach($allStudents as $s): ?>
                            <div class="col-md-3 mb-2">
                                <div class="form-check border rounded p-2">
                                    <input class="form-check-input" type="checkbox"
                                        name="students[]" value="<?= $s['id'] ?>"
                                        <?= in_array($s['id'], array_column($childrenOfParent, 'id'))?'checked':'' ?>>
                                    
                                    <label class="form-check-label">
                                        <?= $s['name'] ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-success px-4" name="assign">
                            Save Assignment
                        </button>
                    </div>

                </form>

            </div>
        </div>
        <?php endif; ?>

    </div>

    <?php include '../includes/footer.php'; ?>

</div>

</body>
</html>
