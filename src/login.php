<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $hashed = hash("sha256", $password);
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("ss", $username, $hashed);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->fetch_assoc()) {
            $_SESSION['user'] = $username;
            header("Location: index.php");
            exit;
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "Username and password required.";
    }
}
?>

<h3>Login</h3>
<form method="POST">
    Username: <input name="username"><br>
    Password: <input name="password" type="password"><br>
    <button type="submit">Login</button>
</form>
<a href="index.php">Back</a>