<?php
session_start();
$username = $_SESSION['user'] ?? null;
$plan = $_SESSION['plan'] ?? null;
$db = mysqli_connect("localhost", "root", "", "real_estate");
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}


?>

