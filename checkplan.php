<?php
session_start();

// If user is not logged in, redirect to login
if (!isset($_SESSION['user'])) {
  header("Location: index.html");
  exit;
}

// Optional: get user plan from sessions
$plan = $_SESSION['plan'] ?? '';
$username = $_SESSION['user'] ?? '';

// Redirect user to their correct dashboard if they landed here by mistake
switch ($plan) {
  case 'free':
    header("Location: freeversion.php");
    exit;
  case 'Monthly':
    header("Location: plana.php");
    exit;
  case 'Quarterly':
    header("Location: planb.php");
    exit;
  case 'Annual':
    header("Location: planc.php");
    exit;
  default:
    // No plan assigned, stay on dashboard
    break;
}
?>