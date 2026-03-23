<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Admin.php';
Auth::requireRole('admin');

$admin = new Admin();
$settings = $admin->getSettings();
$message = '';

// Handle update
if(isset($_POST['update'])){
    $admin->updateSettings($_POST);
    $message = "Settings updated successfully!";
    $settings = $admin->getSettings(); // refresh
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>System Settings</title>
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
            <h3 class="fw-bold">System Settings</h3>
            <p class="text-muted">Configure your system information</p>
        </div>

        <?php if($message): ?>
            <div class="alert alert-success shadow-sm"><?= $message ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-6">
                <!-- Settings Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <form method="POST">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">School Name</label>
                                <input type="text" name="school_name" class="form-control"
                                    value="<?= htmlspecialchars($settings['school_name']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">School Address</label>
                                <input type="text" name="school_address" class="form-control"
                                    value="<?= htmlspecialchars($settings['school_address']) ?>" required>
                            </div>

                            <div class="mt-3">
                                <button class="btn btn-primary px-4" name="update">
                                    Save Changes
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include '../includes/footer.php'; ?>

</div>

</body>
</html>
