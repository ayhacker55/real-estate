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
      <h1>Subscription Details</h1>
      <div class="card-grid">
        <div class="card">
          <h3>Plan Type</h3>
          <p>Pro</p>
        </div>
        <div class="card">
          <h3>Date of Subscription</h3>
          <p><?= htmlspecialchars($user['start_date']) ?></p>
        </div>
      </div>

      <h2 style="margin-top: 30px;">Billing History</h2>
      <table>
        <thead>
          <tr style="background: #e6f4ea;">
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>July 1, 2025</td><td>$29.99</td><td>Paid</td></tr>
          <tr><td>June 1, 2025</td><td>$29.99</td><td>Paid</td></tr>
          <tr><td>May 1, 2025</td><td>$29.99</td><td>Paid</td></tr>
        </tbody>
      </table>

      <div style="margin-top: 24px;">
        <button id="showPlansBtn" style="padding: 10px 16px; background: var(--primary); color: white; border: none; border-radius: 6px; cursor: pointer;">Upgrade Plan</button>

        <div id="plans" style="display:none; margin-top: 20px;">
          <h2>Choose Your Subscription Plan</h2>
          <div class="subscription-container">
           <!--  <div class="plan-card popular">
              <span class="badge">Most Popular</span>
              <h3>Plan B – Quarterly</h3>
              <p>₦13,000<span style="font-size:14px;color:#666;">/quarter</span></p>
              <ul>
                <li>Upload up to 15 properties</li>
                <li>Customer support</li>
                <li>Social media visibility</li>
              </ul>
              <button>Subscribe Now</button>
            </div> -->

            <div class="plan-card">
              <h3>Plan C – Annual</h3>
              <p>₦45,000<span style="font-size:14px;color:#666;">/year</span></p>
              <ul>
                <li>Unlimited property uploads</li>
                <li>Dedicated account manager</li>
                <li>Enhanced product visibility</li>
                <li>Analytics & reporting</li>
              </ul>
              <button>Subscribe Now</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>

<script src="seller.js?v=2"></script>
<script src="allform.js"></script>

<script src="main.js"></script>
</body>
</html>
