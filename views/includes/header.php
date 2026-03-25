<?php
require_once '../../classes/Auth.php';
$user = Auth::user();
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">

        <!-- Sidebar Toggle (for mobile) -->
        <button class="btn btn-outline-primary d-lg-none me-2" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- System Title -->
        <span class="navbar-brand mb-0 h5">Student Monitoring System</span>

        <!-- Right Side -->
        <div class="ms-auto d-flex align-items-center">

            <!-- User Info -->
            <span class="me-3 text-muted">
                <i class="fas fa-user-circle me-1"></i>
                <?php echo htmlspecialchars($user['name'] ?? 'User'); ?>
                (<?php echo ucfirst($user['role']); ?>)
            </span>

            <!-- Logout -->
            <a href="../../views/auth/logout.php" class="btn btn-danger btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>

        </div>

    </div>
</nav>