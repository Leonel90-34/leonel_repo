<?php
require_once '../../classes/Auth.php';
require_once '../../classes/Admin.php';
Auth::requireRole('admin');

$admin = new Admin();
$message = '';

// Handle assignment form submission
if(isset($_POST['assign'])){
    $admin->assignParentToStudents($_POST['parent_id'], $_POST['students'] ?? []);
    $message = "Parent assigned to students successfully!";
}

// Load all parents
$parents = $admin->getParents();

// Selected parent to view current children
$selectedParent = $_GET['parent'] ?? ($parents[0]['id'] ?? null);
$childrenOfParent = $selectedParent ? $admin->getChildrenOfParent($selectedParent) : [];

// Load all students
$allStudents = $admin->getStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Assign Parent to Students</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Assign Parent to Students</h2>

    <?php if($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <!-- Select Parent -->
    <form method="GET" class="mb-3">
        <select name="parent" class="form-select" onchange="this.form.submit()">
            <?php foreach($parents as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $p['id']==$selectedParent?'selected':'' ?>><?= $p['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Assign Students Form -->
    <?php if($selectedParent): ?>
        <form method="POST">
            <input type="hidden" name="parent_id" value="<?= $selectedParent ?>">

            <div class="mb-3">
                <label>Select Students to assign:</label>
                <div class="row">
                    <?php foreach($allStudents as $s): ?>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="students[]" value="<?= $s['id'] ?>"
                                    <?= in_array($s['id'], array_column($childrenOfParent, 'id'))?'checked':'' ?>>
                                <label class="form-check-label"><?= $s['name'] ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button class="btn btn-success" name="assign">Save Assignment</button>
        </form>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
