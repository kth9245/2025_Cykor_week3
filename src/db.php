<?php
$conn = new mysqli("db", "user", "password", "userdb");
if ($conn->connect_error) {
    echo "Error : " . $conn->connect_error;
}
?>