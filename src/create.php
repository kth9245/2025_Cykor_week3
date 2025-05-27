<?php
session_start();
include "db.php";
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $username = $_SESSION['username'];

    $stmt = $conn->prepare("INSERT INTO posts (username, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $title, $content);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error : " . $stmt->error;
    }
}
?>

<h3>Create Post</h3>
<form method="post">
    Title : <input type="text" name="title" required><br>
    Content : <textarea name="content" required></textarea><br>
    <button type="submit">post</button>
</form>
