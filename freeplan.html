<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Seller Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-light: #f9f9f9;
      --bg-dark: #1e1e1e;
      --text-light: #333;
      --text-dark: #f2f2f2;
      --primary: #058b0c;
      --card-light: white;
      --card-dark: #2c2c2c;
    }

    html[data-theme="light"] {
      --bg: var(--bg-light);
      --text: var(--text-light);
      --card: var(--card-light);
    }

    html[data-theme="dark"] {
      --bg: var(--bg-dark);
      --text: var(--text-dark);
      --card: var(--card-dark);
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: var(--bg);
      color: var(--text);
    }

    .dashboard {
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 220px;
      background: var(--card);
      border-right: 1px solid #ddd;
      padding: 24px 16px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      position: relative;
      transition: transform 0.3s ease;
    }

    .sidebar h2 {
      font-size: 20px;
      margin-bottom: 16px;
      color: var(--primary);
    }

    .sidebar button {
      display: block;
      width: 100%;
      background: none;
      border: none;
      text-align: left;
      padding: 10px;
      font-size: 15px;
      color: var(--text);
      cursor: pointer;
      border-radius: 6px;
    }

    .sidebar button:hover {
      background: #e6f4ea;
      color: var(--primary);
    }

    .submenu {
      display: none;
      margin-left: 10px;
      margin-top: 4px;
    }

    .submenu button {
      font-size: 14px;
      padding-left: 20px;
    }

    .submenu.show {
      display: block;
    }

    .logout-btn {
      background: #dc3545;
      color: white;
      border: none;
      padding: 8px 14px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 10px;
    }

    .main {
      flex: 1;
      padding: 24px;
      position: relative;
    }

   .topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-direction: row-reverse; /* ← this moves the switch to left on desktop */
  }
    .theme-switch {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
    }

    .theme-switch input[type="checkbox"] {
      width: 40px;
      height: 20px;
      position: relative;
      appearance: none;
      background: #ccc;
      outline: none;
      border-radius: 20px;
      transition: background 0.3s;
      cursor: pointer;
    }

    .theme-switch input[type="checkbox"]::before {
      content: '';
      position: absolute;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      top: 1px;
      left: 1px;
      background: white;
      transition: transform 0.3s;
    }

    .theme-switch input[type="checkbox"]:checked {
      background: #058b0c;
    }

    .theme-switch input[type="checkbox"]:checked::before {
      transform: translateX(20px);
    }

    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
    }

    .hamburger span {
      width: 25px;
      height: 3px;
      background-color: var(--text);
    }

    .content-section {
      padding: 20px;
    }

    .blur-overlay {
      position: absolute;
      top: 70px;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(4px);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 10;
    }

    .blur-box {
      background: white;
      padding: 24px 32px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      margin-top: -300px;
    }

    .blur-box h3 {
      margin-bottom: 12px;
    }

    .blur-box button {
      background: var(--primary);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
    }




  .subscription-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 24px;
}

/* Card base */
.plan-card {
  flex: 1;
  min-width: 260px;
  position: relative;
  background: linear-gradient(135deg, rgba(5,139,12,0.05) 0%, rgba(255,255,255,1) 100%);
  padding: 24px;
  border-radius: 16px;
  border: 1px solid var(--primary);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s, box-shadow 0.3s;
  overflow: hidden;
}
.plan-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
}

/* “Most Popular” badge */
.plan-card.popular .badge {
  position: absolute;
  top: 16px;
  right: 16px;
  background: var(--primary);
  color: white;
  padding: 4px 10px;
  font-size: 12px;
  font-weight: 600;
  border-radius: 12px;
}

/* Typography */
.plan-card h3 {
  color: var(--primary);
  margin-bottom: 8px;
  font-size: 20px;
}
.plan-card p {
  font-weight: 600;
  font-size: 22px;
  margin: 4px 0 16px;
  color: #444;
}
.plan-card ul {
  padding-left: 20px;
  margin-bottom: 20px;
  font-size: 14px;
  line-height: 1.6;
}
.plan-card ul li {
  margin-bottom: 8px;
}

/* Button */
.plan-card button {
  display: block;
  width: 100%;
  padding: 12px;
  background: var(--primary);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.3s;
}
.plan-card button:hover {
  background: #04690a;
}

/* Mobile stacking */
@media (max-width: 768px) {
  .subscription-container {
    flex-direction: column;
    gap: 16px;
  }
  .plan-card {
    min-width: 100%;
    padding: 16px;
  }
}


    @media (max-width: 768px) {
      .sidebar {
        position:fixed;
        left: 0;
        top: 0;
        bottom: 0;
        transform: translateX(-100%);
        z-index: 100;
        background: var(--card);
      }

      .sidebar.open {
        transform: translateX(0%);
      }

      .hamburger {
        display: flex;
      }

     /*  .main {
        padding: 16px;
      }

      .topbar {
        flex-direction: row;
        justify-content: space-between;
      } */


 
      .topbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 46px;               /* adjust if your topbar is taller/shorter */
    background: var(--card);    /* ensure it sits above the content */
    z-index: 1000;
    padding: 0 16px;            /* match your existing horizontal padding */
  }

  /* 2. Push main content down so it starts below the topbar */
  .main {
    padding: 16px;          /* same as topbar height */
  }

        .blur-box {
      background: white;
      padding: 15px 32px;
     
    }

    .blur-box h3 {
      margin-bottom: 12px;
      font-size: 0.9em;
    }

    .blur-box button {
     
      padding: 10px 20px;
  
    }


    .blur-overlay {
      
      top: 60px;
   
    }
    }
  </style>
</head>
<body>

<div class="dashboard">
  <div id="sidebar" class="sidebar">
    <div>
      <h2>Welcome Mr. Abiodun</h2>
      <button onclick="showTab('home')">🏠 Home</button>

      <button onclick="toggleSubmenu()">➕ Add Properties ▾</button>
      <div id="submenu" class="submenu">
        <button onclick="showAddProperty('Land for Sale')">Land for Sale</button>
        <button onclick="showAddProperty('Land for Rent')">Land for Rent</button>
        <button onclick="showAddProperty('Property for Sale')">Property for Sale</button>
        <button onclick="showAddProperty('Property for Rent')">Property for Rent</button>
        <button onclick="showAddProperty('Shortlet')">Shortlet</button>
         <button onclick="showAddProperty('Decor')">Building Material</button>
        <button onclick="showAddProperty('Decor')">Decor</button>
      </div>

      <button onclick="showTab('subscription')">💳 Subscription</button>
      <button class="logout-btn" onclick="alert('Logging out...')">🚪 Logout</button>
    </div>
  </div>

  <div class="main">
    <div class="topbar">
      <div class="hamburger" onclick="toggleSidebar()">
        <span></span><span></span><span></span>
      </div>
      <div class="theme-switch">
        <label for="themeToggle">🌓</label>
        <input type="checkbox" id="themeToggle" onchange="toggleTheme()" />
      </div>
    </div>

    <div id="home" class="content-section">
      <h1>Welcome to your seller dashboard 👋</h1>
    </div>




<div id="subscription" class="content-section" style="display: none;">
  <h2>Choose Your Subscription Plan</h2>
  <div class="subscription-container">




    <!-- Plan A -->
    <div class="plan-card">
      <h3>Plan A – Monthly</h3>
      <p>₦5,000<span style="font-size:14px;color:#666;">/month</span></p>
      <ul>
        <li>Upload up to 5 properties</li>
        <li>Basic features</li>
        <li>Product upload</li>
        <li>Descriptions & contact details</li>
      </ul>
      <button>Subscribe Now</button>
    </div>
    <!-- Plan B (Most Popular) -->
    <div class="plan-card popular">
      <span class="badge">Most Popular</span>
      <h3>Plan B – Quarterly</h3>
      <p>₦13,000<span style="font-size:14px;color:#666;">/quarter</span></p>
      <ul>
        <li>Upload up to 15 properties</li>
        <li>Customer support</li>
        <li>Social media visibility</li>
      </ul>
      <button>Subscribe Now</button>
    </div>
    <!-- Plan C -->
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


    <div id="addPropertyView" class="blur-overlay" style="display: none;">
      <div class="blur-box">
        <h3>Trial version is over Kindly subscribe to post <span id="propertyType"></span>.</h3>
        <button onclick="showTab('subscription')">Subscribe Now</button>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleTheme() {
    const html = document.documentElement;
    html.dataset.theme = document.getElementById('themeToggle').checked ? "dark" : "light";
  }

  function toggleSubmenu() {
    document.getElementById('submenu').classList.toggle('show');
  }

  function showTab(tabId) {
    document.querySelectorAll('.content-section').forEach(el => el.style.display = 'none');
    document.getElementById('addPropertyView').style.display = 'none';
    const section = document.getElementById(tabId);
    if (section) section.style.display = 'block';

    // Close sidebar on mobile after click
    if (window.innerWidth < 768) {
      document.getElementById('sidebar').classList.remove('open');
    }
  }

  function showAddProperty(type) {
    document.getElementById('propertyType').innerText = type;
    document.getElementById('addPropertyView').style.display = 'flex';

    // Close sidebar on mobile
    if (window.innerWidth < 768) {
      document.getElementById('sidebar').classList.remove('open');
    }
  }

  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
  }
</script>

</body>
</html>
