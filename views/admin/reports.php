<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Admin.php';
Auth::requireRole('admin');

$admin = new Admin();
$reportType = $_GET['type'] ?? 'users';
$reports = [];

switch($reportType){
    case 'grades':
        $reports = $admin->getGradesReport();
        break;
    case 'attendance':
        $reports = $admin->getAttendanceReport();
        break;
    default:
        $reports = $admin->getUsersReport();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Reports</title>
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
            <h3 class="fw-bold">Reports</h3>
            <p class="text-muted">View system-generated reports</p>
        </div>

        <!-- Tabs Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">

                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link <?= $reportType=='users'?'active':'' ?>" href="?type=users">
                            Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $reportType=='grades'?'active':'' ?>" href="?type=grades">
                            Grades
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $reportType=='attendance'?'active':'' ?>" href="?type=attendance">
                            Attendance
                        </a>
                    </li>
                </ul>

            </div>
        </div>

        <!-- Report Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <?php if($reportType=='users'): ?>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                            </tr>
                        <?php elseif($reportType=='grades'): ?>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Subject</th>
                                <th>Grade</th>
                            </tr>
                        <?php elseif($reportType=='attendance'): ?>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        <?php endif; ?>
                    </thead>

                    <tbody>
                        <?php foreach($reports as $r): ?>
                            <tr>

                                <?php if($reportType=='users'): ?>
                                    <td><?= $r['id'] ?></td>
                                    <td><?= $r['name'] ?></td>
                                    <td><?= $r['username'] ?></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= ucfirst($r['role']) ?>
                                        </span>
                                    </td>

                                <?php elseif($reportType=='grades'): ?>
                                    <td><?= $r['id'] ?></td>
                                    <td><?= $r['student_name'] ?></td>
                                    <td><?= $r['subject'] ?></td>
                                    <td>
                                        <span class="badge bg-success">
                                            <?= $r['grade'] ?>
                                        </span>
                                    </td>

                                <?php elseif($reportType=='attendance'): ?>
                                    <td><?= $r['id'] ?></td>
                                    <td><?= $r['student_name'] ?></td>
                                    <td><?= $r['date'] ?></td>
                                    <td>
                                        <span class="badge <?= $r['status']=='present'?'bg-success':'bg-danger' ?>">
                                            <?= ucfirst($r['status']) ?>
                                        </span>
                                    </td>

                                <?php endif; ?>

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
