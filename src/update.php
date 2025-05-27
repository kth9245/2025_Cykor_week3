<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}


$username = $_SESSION['username'];
$is_admin = $_SESSION['is_admin'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("SELECT username FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        echo "No post";
        exit;
    }
    $row = $result->fetch_assoc();
    if ($username != $row['username'] && !$is_admin) {
        echo "No permission";
        exit;
    }

    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $post_id);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error : " . $conn->error;
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        echo "No post";
        exit;
    }

    $row = $result->fetch_assoc();
    if ($username != $row['username'] && !$is_admin) {
        echo "No permission";
        exit;
    }

    echo "<h3>Update Post</h3>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='post_id' value='{$post_id}'>";
    echo "Title: <input type='text' name='title' value='{$row['title']}' required><br>";
    echo "Content: <textarea name='content' required>{$row['content']}</textarea><br>";
    echo "<button type='submit'>Update</button>";
    echo "</form>";
}
?>
