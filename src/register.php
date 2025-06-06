<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->fetch_assoc()) {
        echo "Username already exists.";
    } else {
        $hashed = hash("sha256", $password);
        $stmt = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 0)");
        $stmt->bind_param("ss", $username, $hashed);

        if ($stmt->execute()) {
            echo "Success. <a href='login.php'>Login now</a>";
        } else {
            echo "Error : " . $stmt->error;
        }
    }
}
?>

<h3>Register</h3>
<form method="POST">
    Username: <input name="username" required><br>
    Password: <input name="password" type="password" required><br>
    <button type="submit">Register</button>
</form>
<a href="index.php">Back</a>