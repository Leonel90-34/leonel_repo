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
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Reports</h2>

    <!-- Report Filter Tabs -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link <?= $reportType=='users'?'active':'' ?>" href="?type=users">Users</a></li>
        <li class="nav-item"><a class="nav-link <?= $reportType=='grades'?'active':'' ?>" href="?type=grades">Grades</a></li>
        <li class="nav-item"><a class="nav-link <?= $reportType=='attendance'?'active':'' ?>" href="?type=attendance">Attendance</a></li>
    </ul>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <?php if($reportType=='users'): ?>
                    <tr><th>ID</th><th>Name</th><th>Username</th><th>Role</th></tr>
                <?php elseif($reportType=='grades'): ?>
                    <tr><th>ID</th><th>Student</th><th>Subject</th><th>Grade</th></tr>
                <?php elseif($reportType=='attendance'): ?>
                    <tr><th>ID</th><th>Student</th><th>Date</th><th>Status</th></tr>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php foreach($reports as $r): ?>
                    <tr>
                        <?php if($reportType=='users'): ?>
                            <td><?= $r['id'] ?></td>
                            <td><?= $r['name'] ?></td>
                            <td><?= $r['username'] ?></td>
                            <td><?= $r['role'] ?></td>
                        <?php elseif($reportType=='grades'): ?>
                            <td><?= $r['id'] ?></td>
                            <td><?= $r['student_name'] ?></td>
                            <td><?= $r['subject'] ?></td>
                            <td><?= $r['grade'] ?></td>
                        <?php elseif($reportType=='attendance'): ?>
                            <td><?= $r['id'] ?></td>
                            <td><?= $r['student_name'] ?></td>
                            <td><?= $r['date'] ?></td>
                            <td><?= ucfirst($r['status']) ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
