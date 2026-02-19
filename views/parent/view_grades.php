<?php
require_once '../../classes/Auth.php';
require_once '../../classes/ParentUser.php';
Auth::requireRole('parent');

$parent = new ParentUser();
$children = $parent->getChildren();
$selectedChild = $_GET['student'] ?? ($children[0]['id'] ?? null);

$grades = $selectedChild ? $parent->getGrades($selectedChild) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Grades</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Student Grades</h2>

    <?php if($children): ?>
        <form method="GET" class="mb-3">
            <select name="student" class="form-select" onchange="this.form.submit()">
                <?php foreach($children as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id']==$selectedChild?'selected':'' ?>><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr><th>Subject</th><th>Grade</th></tr>
                </thead>
                <tbody>
                    <?php foreach($grades as $g): ?>
                        <tr>
                            <td><?= $g['subject'] ?></td>
                            <td><?= $g['grade'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No children assigned to this parent.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
