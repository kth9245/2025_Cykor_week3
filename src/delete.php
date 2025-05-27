<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $username = $_SESSION['username'];
    $is_admin = $_SESSION['is_admin'];

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

    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error : " . $conn->error;
    }
}
?>