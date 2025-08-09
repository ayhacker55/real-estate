<?php 
session_start();

// If user is not logged in, redirect to login
if (!isset($_SESSION['user'])) {
  header("Location: index.html");
  exit;
}
$username=$_SESSION['user'];
include('header.php');
?>
<!-- ✅ Optional Styling (if you're not using Bootstrap) -->
<style>
.property-card {
  display: flex;
  align-items: flex-start;
  border: 1px solid #ddd;
  border-radius: 8px;
  margin-bottom: 15px;
  padding: 10px;
  gap: 15px;
}
.property-image {
  width: 150px;
  height: 100px;
  object-fit: cover;
  border-radius: 5px;
}
.property-info h3 {
  margin: 0 0 5px;
}
.rejection-message {
  color: red;
  font-weight: bold;
  margin-top: 5px;
}

.pagination {
  list-style: none;
  padding: 0;
  display: flex;
  justify-content: center;
  gap: 6px;
}
.pagination .page-item {
  display: inline-block;
}
.pagination .page-link {
  display: inline-block;
  padding: 6px 12px;
  text-decoration: none;
  color: #007bff;
  border: 1px solid #ddd;
  border-radius: 4px;
}
.pagination .active .page-link {
  background-color: #007bff;
  color: white;
  border-color: #007bff;
}
</style>

<?php

$db = mysqli_connect("localhost", "root", "", "real_estate") or die("Could not connect");

// Assume the user is logged in and username is stored in session
$username = $_SESSION['user'] ?? null;

    // Fetch the logged-in user's details
    $query = "SELECT * FROM `users` WHERE `username` = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

?>
<body>
<div class="dashboard">
<?php include('menu.php');?>

  <div class="main">
    <div class="topbar">
      <div class="hamburger" onclick="toggleSidebar()">
        <span></span><span></span><span></span>
      </div>
      <div class="theme-switch">
        <label for="themeToggle">🌓</label>
        <input type="checkbox" id="themeToggle" onchange="toggleTheme()">
      </div>
    </div>





<!-- Profile Tab -->
<div id="profile" class="tab active">
  <h2>User Profile</h2>

  <div class="profile-tabs">
    <button class="profile-tab-btn active" data-profile-tab="view">👁️ View</button>
    <button class="profile-tab-btn" data-profile-tab="update">🔒 Update Password</button>
  </div>

  <!-- View Profile Section -->
  <div id="profile-view" class="profile-tab-content active">
    <label>Name:</label>
    <input type="text" value="<?= htmlspecialchars($user['fullname']) ?>" readonly>

    <label>Phone:</label>
    <input type="text" value="<?= htmlspecialchars($user['phone']) ?>" readonly>

    <label>Email:</label>
    <input type="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>

    <label>Password:</label>
    <input type="password" value="<?= str_repeat('*', 8) ?>" readonly>
  </div>

  <!-- Update Password Section -->
  <div id="profile-update" class="profile-tab-content">
    <form action="update_password.php" method="post">
      <label>Current Password:</label>
      <input type="password" name="current_password" placeholder="Enter current password" required>

      <label>New Password:</label>
      <input type="password" name="new_password" placeholder="Enter new password" required>

      <button type="submit">Update Password</button>
    </form>
  </div>
</div>



    
  </div>

<script src="seller.js?v=2"></script>
<script src="allform.js"></script>

<script src="main.js"></script>
</body>
</html>
