<?php
session_start();

$username = $_SESSION['user'] ?? null;

$conn = mysqli_connect("localhost", "root", "", "real_estate");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get parameters
$planName = $_GET['name'] ?? null;   // plan name
$planType = $_GET['plan'] ?? null;   // plan type
$days     = $_GET['days'] ?? null;   // number of days

if (!$username || !$planName || !$planType || !$days) {
    die("Missing required parameters.");
}

// Dates
$start_date = date('Y-m-d');
$end_date = date('Y-m-d', strtotime("+$days days"));

// 1. Update users table (set active plan name)
$stmt = $conn->prepare("UPDATE users SET plan = ? WHERE username = ?");
$stmt->bind_param("ss", $planType, $username);
$stmt->execute();
$stmt->close();

// 2. Update plans table
$stmt = $conn->prepare("
    UPDATE plans 
    SET name=?, type=?, start_date=?, end_date=?, days=? 
    WHERE username = ?
");
$stmt->bind_param("ssssds", $planName, $planType, $start_date, $end_date, $days, $username);
$stmt->execute();
$stmt->close();

$_SESSION['plan'] = $planType;

// Redirect to dashboard
header("Location: dashboard.php");
exit();
?>
