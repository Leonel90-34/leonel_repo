<?php
require_once '../../classes/Auth.php';
$user = Auth::user();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Student Monitoring</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <?php if($user['role'] == 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="../admin/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="../admin/manage_users.php">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="../admin/assign_parent.php">Assign Parent</a></li>
                    <li class="nav-item"><a class="nav-link" href="../admin/system_settings.php">Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="../admin/reports.php">Reports</a></li>
                <?php elseif($user['role'] == 'teacher'): ?>
                    <li class="nav-item"><a class="nav-link" href="../teacher/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="../teacher/encode_grades.php">Grades</a></li>
                    <li class="nav-item"><a class="nav-link" href="../teacher/attendance.php">Attendance</a></li>
                    <li class="nav-item"><a class="nav-link" href="../teacher/manage_test.php">Tests</a></li>
                    <li class="nav-item"><a class="nav-link" href="../teacher/send_notification.php">Message</a></li>
                <?php elseif($user['role'] == 'dean'): ?>
                    <li class="nav-item"><a class="nav-link" href="../dean/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="../dean/manage_faculty.php">Faculty</a></li>
                <?php elseif($user['role'] == 'parent'): ?>
                    <li class="nav-item"><a class="nav-link" href="../parent/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="../parent/notifications.php">Notifications</a></li>
                    <li class="nav-item"><a class="nav-link" href="../parent/view_grades.php">Grades</a></li>
                <?php elseif($user['role'] == 'student'): ?>
                    <li class="nav-item"><a class="nav-link" href="../student/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="../student/notifications.php">Notifications</a></li>
                    <li class="nav-item"><a class="nav-link" href="../student/view_grades.php">Grades</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="../../logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
