<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE name=?");
    $stmt->bind_param("sss", $name, $email, $_SESSION['user']);

    if ($stmt->execute()) {
        $_SESSION['user'] = $name; // update session
        header("Location: profile.php");
    } else {
        echo "error";
    }
}
?>