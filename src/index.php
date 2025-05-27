<?php
session_start();
?>

<?php if (isset($_SESSION['username'])): ?>
    <p>Hello, <?= $_SESSION['username']?>!</p>
    <a href="create.php">Create Post</a><br>
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a><br>
    <a href="register.php">Register</a>
<?php endif; ?>

<?php
include "db.php";

$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");

echo "<h2>Posts</h2>";
$num = 1;
while ($row=$result->fetch_assoc()) {
    echo "<div>";
    echo "<h3>" . $num . " : " . $row['title'] . "</h3>";
    echo "<p>" . $row['content'] . "</p>";
    echo "<small>Writer : " . $row['username'] . " , " . $row['created_at'] . "</small>";
    if (isset($_SESSION['username']) && ($_SESSION['username'] == $row['username'] || $_SESSION['is_admin'])) {
        echo "<form method='get' action='update.php'>";
        echo "<input type='hidden' name='post_id' value='{$row['id']}'>";
        echo "<button type='submit'>update</button>";
        echo "</form>";
        
        echo "<form method='post' action='delete.php'>";
        echo "<input type='hidden' name='post_id' value='{$row['id']}'>";
        echo "<button type='submit'>delete</button>";
        echo "</form>";
    }
    echo "</div>";
    $num++;
}
?>