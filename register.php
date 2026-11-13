<?php
require 'db.php';

$message = "";

if (isset($_POST['register'])) {
    $full_name        = trim($_POST['full_name']);
    $username         = trim($_POST['username']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $check_user = $connection->prepare("SELECT id FROM users WHERE username = ?");
    $check_user->execute([$username]);

    if ($check_user->fetch()) {
        $message = "This account already exists.";
    }
    elseif ($password != $confirm_password) {
        $message = "Passwords do not match.";
    }
    else {
        $save_user = $connection->prepare(
            "INSERT INTO users (full_name, username, password) VALUES (?, ?, ?)"
        );
        $save_user->execute([$full_name, $username, $password]);

        header("Location: login.php?registered=yes");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post" class="box">
        <h1>Registration</h1>

        <?php if ($message != ""): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>

        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" name="register">Register</button>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
</body>
</html>