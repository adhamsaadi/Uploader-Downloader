<?php
session_start();

$correctUsername = 'YourUsername';
$correctPassword = 'YourPassword';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === $correctUsername && $_POST['password'] === $correctPassword) {
        $_SESSION['authenticated'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        Username: <input type="text" name="username"><br><br>
        Password: <input type="password" name="password"><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
