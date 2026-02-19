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
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>System Settings</h2>

    <?php if($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>School Name</label>
            <input type="text" name="school_name" class="form-control" value="<?= htmlspecialchars($settings['school_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>School Address</label>
            <input type="text" name="school_address" class="form-control" value="<?= htmlspecialchars($settings['school_address']) ?>" required>
        </div>
        <button class="btn btn-primary" name="update">Update Settings</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
