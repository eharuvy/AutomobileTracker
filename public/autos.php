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
<html>
<head>
    <title>Ethan Haruvy</title>
    <style>
        body  { font-family: Arial, sans-serif; margin: 40px; }
        .error   { color: red;   margin-bottom: 10px; }
        .success { color: green; margin-bottom: 10px; }
        label { display: inline-block; width: 80px; }
        input[type=text] { width: 180px; padding: 4px; }
        table { border-collapse: collapse; margin-top: 20px; width: 70%; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn-logout { margin-left: 10px; padding: 6px 14px; }
    </style>
</head>

<body>

<h1>Autos</h1>
<p>Hello, <?= htmlentities($name) ?></p>

<!-- Keep name in URL -->
<form method="post" action="autos.php?name=<?= urlencode($name) ?>">

    <?php if (strlen($error) > 0): ?>
        <p class="error"><?= htmlentities($error) ?></p>
    <?php endif; ?>

    <?php if (strlen($success) > 0): ?>
        <p class="success"><?= htmlentities($success) ?></p>
    <?php endif; ?>

    <p>
        <label for="make">Make:</label>
        <input type="text" name="make" id="make"
               value="<?= isset($_POST['make']) && strlen($error) > 0 ? htmlentities($_POST['make']) : '' ?>">
    </p>

    <p>
        <label for="year">Year:</label>
        <input type="text" name="year" id="year"
               value="<?= isset($_POST['year']) && strlen($error) > 0 ? htmlentities($_POST['year']) : '' ?>">
    </p>

    <p>
        <label for="mileage">Mileage:</label>
        <input type="text" name="mileage" id="mileage"
               value="<?= isset($_POST['mileage']) && strlen($error) > 0 ? htmlentities($_POST['mileage']) : '' ?>">
    </p>

    <p>
        <input type="submit" name="add" value="Add">
        <input type="submit" name="logout" value="Logout" class="btn-logout">
    </p>
</form>

<!-- Autos Table -->
<?php if (count($rows) > 0): ?>
<table>
    <tr>
        <th>Make</th>
        <th>Year</th>
        <th>Mileage</th>
        <th>Action</th>
    </tr>

    <?php foreach ($rows as $row): ?>
    <tr>
        <td><?= htmlentities($row['make']) ?></td>
        <td><?= htmlentities($row['year']) ?></td>
        <td><?= htmlentities($row['mileage']) ?></td>

        <td>
            <form method="post" style="display:inline;">
                <input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
                <input type="submit" name="delete" value="Delete"
                       onclick="return confirm('Delete this record?');">
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

</body>
</html>
