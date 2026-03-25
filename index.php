<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: views/auth/login.php");
    exit;
}

// Redirect based on role
switch ($_SESSION['role']) {
    case 'admin':
        header("Location: views/admin/dashboard.php");
        break;
    case 'dean':
        header("Location: views/dean/dashboard.php");
        break;
    case 'teacher':
        header("Location: views/teacher/dashboard.php");
        break;
    case 'parent':
        header("Location: views/parent/dashboard.php");
        break;
    case 'student':
        header("Location: views/student/dashboard.php");
        break;
    default:
        echo "Role not found!";
}
