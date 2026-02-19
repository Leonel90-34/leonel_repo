<?php
require_once '../../classes/Auth.php';
require_once '../../classes/ParentUser.php';
Auth::requireRole('parent');

$parent = new ParentUser();
$notifications = $parent->getNotifications();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Notifications</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Notifications</h2>

    <?php if($notifications): ?>
        <ul class="list-group">
            <?php foreach($notifications as $n): ?>
                <li class="list-group-item">
                    <strong><?= date('Y-m-d H:i', strtotime($n['created_at'])) ?>:</strong> <?= $n['message'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No notifications.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
