<?php
// autos.php - Ethan Haruvy

// Stop immediately if not logged in
if (!isset($_GET['name']) || strlen(trim($_GET['name'])) < 1) {
    die("Name parameter missing");
}

$name = $_GET['name'];

// Handle logout
if (isset($_POST['logout'])) {
    header('Location: index.php');
    exit();
}

// Connect to the database
require_once __DIR__ . '/../src/pdo.php';

$error   = '';
$success = '';

// Handle Add button
if (isset($_POST['add'])) {
    $make    = $_POST['make']    ?? '';
    $year    = $_POST['year']    ?? '';
    $mileage = $_POST['mileage'] ?? '';

    if (strlen(trim($make)) < 1) {
        $error = 'Make is required';
    }
    elseif (!is_numeric($year) || !is_numeric($mileage)) {
        $error = 'Mileage and year must be numeric';
    }
    else {
        $stmt = $pdo->prepare(
            'INSERT INTO autos (make, year, mileage) VALUES (:mk, :yr, :mi)'
        );
        $stmt->execute(array(
            ':mk' => $make,
            ':yr' => $year,
            ':mi' => $mileage
        ));
        $success = 'Record inserted';
    }
}

// Handle Delete button
if (isset($_POST['delete']) && isset($_POST['auto_id'])) {
    $stmt = $pdo->prepare('DELETE FROM autos WHERE auto_id = :id');
    $stmt->execute(array(
        ':id' => $_POST['auto_id']
    ));
    $success = 'Record deleted';
}

// Fetch all autos sorted by make
$stmt = $pdo->prepare('SELECT * FROM autos ORDER BY make');
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutomobileTracker Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-FY1bJKl+Z6Bml6BnZbBpqjNi9HZxiQWGOe+F2dMZtqBGaH3Juu8FwwUK4Eb7y4x0" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Automobile Inventory</h1>
            <p class="text-muted mb-0">Hello, <?= htmlentities($name) ?></p>
        </div>
        <form method="post" action="autos.php?name=<?= urlencode($name) ?>">
            <button type="submit" name="logout" class="btn btn-outline-secondary">Logout</button>
        </form>
    </div>

    <?php if (strlen($error) > 0): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlentities($error) ?>
        </div>
    <?php endif; ?>

    <?php if (strlen($success) > 0): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlentities($success) ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h2 class="h5">Add a new automobile</h2>
            <form method="post" action="autos.php?name=<?= urlencode($name) ?>">
                <div class="row gy-3">
                    <div class="col-md-4">
                        <label for="make" class="form-label">Make</label>
                        <input type="text" class="form-control" id="make" name="make" value="<?= isset($_POST['make']) && strlen($error) > 0 ? htmlentities($_POST['make']) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="year" class="form-label">Year</label>
                        <input type="text" class="form-control" id="year" name="year" value="<?= isset($_POST['year']) && strlen($error) > 0 ? htmlentities($_POST['year']) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="mileage" class="form-label">Mileage</label>
                        <input type="text" class="form-control" id="mileage" name="mileage" value="<?= isset($_POST['mileage']) && strlen($error) > 0 ? htmlentities($_POST['mileage']) : '' ?>">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" name="add" class="btn btn-primary">Add Automobile</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="h5 mb-3">Registered Automobiles</h2>
            <?php if (count($rows) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Make</th>
                                <th>Year</th>
                                <th>Mileage</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td><?= htmlentities($row['make']) ?></td>
                                    <td><?= htmlentities($row['year']) ?></td>
                                    <td><?= htmlentities($row['mileage']) ?></td>
                                    <td class="text-end">
                                        <form method="post" class="d-inline" onsubmit="return confirm('Delete this record?');">
                                            <input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
                                            <button type="submit" name="delete" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted mb-0">No automobiles have been added yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
