<?php 
session_start();

// If user is not logged in, redirect to login
if (!isset($_SESSION['user'])) {
  header("Location: index.html");
  exit;
}
$username=$_SESSION['user'];
include('header.php');
include ('db.php');
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



<!-- approval -->

    <!-- Subscription Tab -->
    <div id="subscription" class="tab active">
     <h2>Priority Customer Care</h2>
  <p>Need help? Reach out to any of our top support agents below:</p>

 <div class="table-responsive">
  <table class="customer-care-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>WhatsApp</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Jane Doe</td>
        <td><a href="tel:+2348023456789">+234 802 345 6789</a></td>
        <td><a href="mailto:jane@example.com">jane@example.com</a></td>
        <td><a href="https://wa.me/2348023456789" target="_blank">
          <i class="fab fa-whatsapp" style="color:green;"></i>
        </a></td>
      </tr>
    </tbody>
  </table>
</div>
    </div>
    
  </div>

<script src="seller.js?v=2"></script>
<script src="allform.js"></script>

<script src="main.js"></script>
</body>
</html>
