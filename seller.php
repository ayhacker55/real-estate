<?php 
session_start();
$plan = $_SESSION['plan'] ?? '';
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


    $countQuery = "SELECT COUNT(*) as total FROM `property` WHERE `publish` = 'pending' AND `username`='$username'";
$countResult = mysqli_query($db, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$total_items = $countRow['total'];

  $countQuery2 = "SELECT COUNT(*) as totalupload FROM `property` WHERE `username`='$username'";
$countResult2 = mysqli_query($db, $countQuery2);
$countRow2 = mysqli_fetch_assoc($countResult2);
$upload = $countRow2['totalupload'];

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



    <!-- Home Tab -->
    <div id="home" class="tab active">
      <h1>Overview</h1>
      <div class="card-grid">
        <div class="card"><h3>Total Uploads</h3><p><?php echo $upload; ?></p></div>
        <div class="card"><h3>Pending Approval</h3><p><?php echo $total_items; ?></p></div>
      </div>
    </div>




<!-- approval -->

  </div>

<script src="seller.js?v=2"></script>
<script src="allform.js"></script>

<script src="main.js"></script>
</body>
</html>
