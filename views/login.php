<?php
session_start();
require_once '../config.php';
require_once '../classes/User.php';

$message = '';
if (isset($_POST['login'])) {
    $user = new User();
    $result = $user->login($_POST['username'], $_POST['password']);
    if ($result) {
        // Secure session
        session_regenerate_id(true); // prevent session fixation
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['role'] = $result['role'];
        header("Location: ../index.php");
    } else {
        $message = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Student Monitoring System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-3">Login</h3>
                        <?php if ($message) echo '<div class="alert alert-danger">' . $message . '</div>'; ?>
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success">Logout Successfully!</div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button name="login" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
if (isset($_GET['timeout'])) {
    echo '<div class="alert alert-warning">Session expired due to inactivity. Please login again.</div>';
}
?>