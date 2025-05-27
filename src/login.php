<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed = hash("sha256", $password);
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    if (!$stmt) {
        echo "Error : " . $conn->error;
    }
    $stmt->bind_param("ss", $username, $hashed);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row=$result->fetch_assoc()) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['is_admin'] = $row['is_admin'];
        header("Location: index.php");
        exit;
    } else {
        echo "No account.";
    }
}
?>

<h3>Login</h3>
<form method="POST">
    Username: <input name="username" required><br>
    Password: <input name="password" type="password" required><br>
    <button type="submit">Login</button>
</form>
<a href="index.php">Back</a>