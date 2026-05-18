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
<html>
<head>
    <title>Ethan Haruvy</title>
    <style>
        body  { font-family: Arial, sans-serif; margin: 40px; }
        .error { color: red; margin-bottom: 10px; }
        label { display: inline-block; width: 80px; }
        input[type=text], input[type=password] { width: 200px; padding: 4px; }
        input[type=submit] { margin-top: 10px; padding: 6px 16px; }
    </style>
</head>
<body>
<h1>Please Log In</h1>

<?php if (strlen($error) > 0): ?>
    <p class="error"><?= htmlentities($error) ?></p>
<?php endif; ?>

<form method="post">
    <p>
        <label for="who">Email:</label>
        <input type="text" name="who" id="who"
               value="<?= isset($_POST['who']) ? htmlentities($_POST['who']) : '' ?>">
    </p>
    <p>
        <label for="pass">Password:</label>
        <input type="password" name="pass" id="pass">
    </p>
    <p>
        <input type="submit" value="Log In">
    </p>
</form>
</body>
</html>
