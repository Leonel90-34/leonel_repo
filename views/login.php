<?php
session_start();
require_once '../config.php';
require_once '../classes/User.php';

$message = '';
if (isset($_POST['login'])) {
    $user = new User();
    $result = $user->login($_POST['username'], $_POST['password']);
    if ($result) {
        session_regenerate_id(true); // prevent session fixation
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['role'] = $result['role'];
        header("Location: ../index.php");
        exit;
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
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6c5ce7, #00b894);
            position: relative;
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Animated shapes in background */
        body::before, body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: 0.3;
            animation: float 15s infinite alternate;
        }

        body::before {
            width: 500px;
            height: 500px;
            background: #ffeaa7;
            top: -150px;
            left: -150px;
        }

        body::after {
            width: 400px;
            height: 400px;
            background: #fab1a0;
            bottom: -100px;
            right: -100px;
        }

        @keyframes float {
            0% { transform: translateY(0) translateX(0) rotate(0deg); }
            100% { transform: translateY(-50px) translateX(50px) rotate(45deg); }
        }

        .login-card {
            border-radius: 15px;
            backdrop-filter: blur(10px);
            background-color: rgba(255,255,255,0.85);
            padding: 2rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow login-card">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Student Monitoring System</h3>

                        <?php if ($message): ?>
                            <div class="alert alert-danger"><?= $message ?></div>
                        <?php endif; ?>

                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success">Logout Successfully!</div>
                        <?php endif; ?>

                        <?php if (isset($_GET['timeout'])): ?>
                            <div class="alert alert-warning">Session expired due to inactivity. Please login again.</div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        </form>

                    </div>
                </div>
                <p class="text-center text-white mt-3">© <?= date('Y') ?> Student Monitoring System</p>
            </div>
        </div>
    </div>

</body>
</html>
