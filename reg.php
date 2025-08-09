<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "real_estate";

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$conn->query("CREATE DATABASE IF NOT EXISTS $db");
$conn->select_db($db);

// Table
$conn->query("
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(100),
  username VARCHAR(50) UNIQUE,
  email VARCHAR(100) UNIQUE,
  phone VARCHAR(15),
  password VARCHAR(255),
  otp VARCHAR(6),
  verified TINYINT DEFAULT 0,
  plan VARCHAR(50)
)
");

// Register
if ($_POST['action'] === 'register') {
  $fullname = $conn->real_escape_string($_POST['fullname']);
  $username = $conn->real_escape_string($_POST['username']);
  $email = $conn->real_escape_string($_POST['email']);
  $phone = $conn->real_escape_string($_POST['phone']);
  $password = $conn->real_escape_string($_POST['password']); // store as plain text (not recommended)
  $otp = rand(100000, 999999);

  // Calculate start and end dates
  $start_date = date('Y-m-d');
  $end_date = date('Y-m-d', strtotime('+30 days', strtotime($start_date)));

  $check = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$email'");
  if ($check->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username or email already exists.']); 
    exit;
  }

  // Fixed missing comma in your INSERT
  $insert = $conn->query("INSERT INTO users (fullname, username, email, phone, password, otp, plan) 
                          VALUES ('$fullname', '$username', '$email', '$phone', '$password', '$otp', 'freeversion')");

  // Insert into plans table with correct dates
  $insert2 = $conn->query("INSERT INTO `plans`(`username`, `name`, `type`, `total_upload`, `start_date`, `end_date`) 
                           VALUES ('$username', 'freeversion', 'freeversion', '0', '$start_date', '$end_date')");

  if ($insert && $insert2) {
    echo json_encode(['status' => 'success', 'message' => 'Registration successful. OTP sent.', 'otp' => $otp]);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed.']);
  }
  exit;
}


// Login (username or email)
if ($_POST['action'] === 'login') {
  $input = $conn->real_escape_string($_POST['username']);
  $password = $conn->real_escape_string($_POST['password']);

  $query = $conn->query("SELECT * FROM users WHERE username='$input' OR email='$input'");
  if ($query->num_rows === 1) {
    $user = $query->fetch_assoc();
    if ($password === $user['password']) {
      $_SESSION['user'] = $user['username'];
      $_SESSION['plan'] = $user['plan'];

      if ($user['plan'] === 'free') {
        echo json_encode([
          'status' => 'success',
          'message' => 'Login successful. Redirecting to free plan page.',
          'redirect' => 'freeplan.php'
        ]);
      } elseif (empty($user['plan'])) {
        echo json_encode([
          'status' => 'success',
          'message' => 'Login successful. Staying on dashboard.',
          'redirect' => 'dashboard.php'
        ]);
      } else {
        echo json_encode([
          'status' => 'success',
          'message' => 'Login successful.',
          'redirect' => 'dashboard.php'
        ]);
      }

    } else {
      echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
    }
  } else {
    echo json_encode(['status' => 'error', 'message' => 'User not found.']);
  }
  exit;
}
?>
