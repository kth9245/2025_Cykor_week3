<?php
session_start();
?>

<?php if (isset($_SESSION['user'])): ?>
    <p>Hello, <?= htmlspecialchars($_SESSION['user']) ?>!</p>
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a><br>
    <a href="register.php">Register</a>
<?php endif; ?>
