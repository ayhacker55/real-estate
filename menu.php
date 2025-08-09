  <div id="sidebar" class="sidebar">
    <h2>Dashboard</h2>

    <div class="menu-item">
      <button class="tab-btn" data-tab="home">🏠 Home</button>
    </div>

    <!-- Add Properties Button -->
    <div class="menu-item">
      <button class="tab-btn" data-tab="add">➕ Add Properties</button>
      <div class="submenu" style="display: none;">
        <button class="submenu-btn"><a href="land.php">Land</a></button>
        <button class="submenu-btn" ><a href ='property.php'>Property</a></button>
        <button class="submenu-btn" ><a href="shortlet.php">Shortlet</a></button>
        <button class="submenu-btn" ><a  href="decor.php"> Decor</a></button>
        <button class="submenu-btn" ><a href='building.php'>Building Material</a></button>
      </div>
    </div>

    <!-- View Property Button -->
    <div class="menu-item">
      <button class="tab-btn" data-tab="view">🔍 View Property</button>
      <div class="submenu" style="display: none;">
        <button class="submenu-btn" data-form="active">Active</button>
        <button class="submenu-btn" data-form="pending">Pending Approval</button>
      </div>
    </div>

   <div class="menu-item vertical-buttons">
  <button class="tab-btn" data-tab="subscription">📦 Subscription</button>
  <button class="tab-btn" data-tab="profile">👤 Profile</button>
  <button class="logout-btn" onclick="alert('Logging out...')">🚪 Logout</button>
</div>

  </div>