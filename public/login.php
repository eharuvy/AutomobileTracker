<?php
// login.php - Ethan Haruvy

$salt = 'XyZzy12*_';
$stored_hash = 'db91fad96371a852afccf456d7af7a88'; // md5('php123' + salt)

$error = '';

if (isset($_POST['who']) && isset($_POST['pass'])) {
    $who  = $_POST['who'];
    $pass = $_POST['pass'];

    // Check 1: blank fields
    if (strlen(trim($who)) < 1 || strlen(trim($pass)) < 1) {
        $error = 'Email and password are required';
    }
    // Check 2: must have @ sign
    elseif (strpos($who, '@') === false) {
        $error = 'Email must have an at-sign (@)';
    }
    // Check 3: verify password using hash
    else {
        $check = md5($pass . $salt);
        if ($check === $stored_hash) {
            error_log("Login success " . $who);
            header("Location: autos.php?name=" . urlencode($who));
            exit();
        } else {
            error_log("Login fail " . $who . " " . $check);
            $error = 'Incorrect password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutomobileTracker Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-FY1bJKl+Z6Bml6BnZbBpqjNi9HZxiQWGOe+F2dMZtqBGaH3Juu8FwwUK4Eb7y4x0" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-3">Sign in</h1>
                    <p class="text-muted">Use your email and password to access the automobile tracker.</p>

                    <?php if (strlen($error) > 0): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlentities($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" class="mb-3">
                        <div class="mb-3">
                            <label for="who" class="form-label">Email</label>
                            <input type="text" name="who" id="who" class="form-control" value="<?= isset($_POST['who']) ? htmlentities($_POST['who']) : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" name="pass" id="pass" class="form-control">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Log In</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <a href="index.php" class="link-secondary">Back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
