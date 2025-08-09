<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
  echo json_encode(['status' => 'error', 'message' => 'You are not logged in.']);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$plan = $data['plan'] ?? '';

if (!$plan) {
  echo json_encode(['status' => 'error', 'message' => 'No plan selected.']);
  exit;
}

require 'db.php'; // contains $conn setup

$username = $_SESSION['user'];

if ($plan === 'free') {
  $start_date = date('Y-m-d');
  $end_date = date('Y-m-d', strtotime('+7 days'));

  $stmt = $conn->prepare("UPDATE users SET plan = ?, start_date = ?, end_date = ? WHERE username = ?");
  $stmt->bind_param("ssss", $plan, $start_date, $end_date, $username);
} else {
  $stmt = $conn->prepare("UPDATE users SET plan = ? WHERE username = ?");
  $stmt->bind_param("ss", $plan, $username);
}

if ($stmt->execute()) {
  $_SESSION['plan'] = $plan;
  $response = ['status' => 'success', 'message' => 'Plan updated to ' . $plan];
  if ($plan === 'free') {
    $response['redirect'] = 'freeplan.php';
  }
  echo json_encode($response);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Failed to update plan.']);
}
?>
