<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Seller Plan Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

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
      background: var(--bg);
      color: var(--text);
    }
    .dashboard { display: flex; min-height: 100vh; flex-wrap: wrap; }
    .sidebar {
      width: 220px;
      background: var(--card);
      border-right: 1px solid #ddd;
      padding: 24px 16px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      transition: transform 0.3s ease;
    ;
     
    }
    .sidebar h2 { font-size: 20px; color: var(--primary); margin-bottom: 16px; }
    .sidebar button {
      background: none; border: none; text-align: left;
      padding: 10px; font-size: 15px; color: var(--text); cursor: pointer; border-radius: 6px;
    }
    .sidebar button:hover,
    .sidebar button.active { background: #e6f4ea; color: var(--primary); }

    .submenu {
      display: none;
      flex-direction: column;
      gap: 8px;
      margin-left: 12px;
      margin-top: 4px;
    }
    .submenu button {
      display: block;
      width: 100%;
      padding-left: 20px;
      text-align: left;
      background: none;
      border: none;
      color: var(--text);
      cursor: pointer;
      border-radius: 4px;
    }
    .submenu button:hover { background: #f0f0f0; }

    .logout-btn {
      background: #dc3545;
      color: white;
      border: none;
      padding: 8px;
      border-radius: 6px;
      cursor: pointer;
    }

    /* profile picture */
#profile input {
  display: block;
  width: 100%;
  margin-bottom: 16px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

.profile-tabs {
  display: flex;
  gap: 12px;
  margin-bottom: 20px;
}

.profile-tab-btn {
  padding: 10px 16px;
  border: none;
  background: var(--primary, #007bff);
  color: white;
  border-radius: 6px;
  cursor: pointer;
  opacity: 0.7;
}

.profile-tab-btn.active {
  opacity: 1;
  background: var(--accent, #28a745);
}

.profile-tab-content {
  display: none;
}

.profile-tab-content.active {
  display: block;
}

    /* end of profile pictyure */

    .vertical-buttons {
  display: flex;
  flex-direction: column;
  gap: 10px; /* Adds spacing between buttons */
}


     .main { flex: 1; 
      padding:20px ; 
      position: relative; 
        overflow-y: auto;   
        height: 100vh;
        width: -200px;
    }
   
     .topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  overflow-x: auto;
  padding-bottom: 8px;
 
  
  position: sticky;
  top:0;
  z-index: 1000; 
     } 

/* over for the btn */

.tab-btn:hover,
.submenu-btn:hover {
  background-color: #28a745; /* green */
  color: white;
}

/* For mobile touch (active/focus) */
.tab-btn:active,
.tab-btn:focus,
.submenu-btn:active,
.submenu-btn:focus {
  background-color: #28a745; /* green */
  color: white;
  outline: none;
}

.tab-btn,
.submenu-btn {
  transition: background-color 0.3s ease;
}


.tab-btn,
.submenu-btn {
  touch-action: manipulation;
}

/* over for the btn */
    
    .theme-switch {
      display: flex; align-items: center; gap: 8px; font-size: 14px;
    }
    .theme-switch input[type="checkbox"] {
      width: 40px; height: 20px; position: relative; appearance: none;
      background: #ccc; outline: none; border-radius: 20px;
      transition: background .3s; cursor: pointer;
    }
    .theme-switch input[type="checkbox"]::before {
      content: ''; position: absolute; width: 18px; height: 18px;
      background: white; border-radius: 50%; top:1px; left:1px; transition: transform .3s;
    }
    .theme-switch input:checked { background: var(--primary); }
    .theme-switch input:checked::before { transform: translateX(20px); }
    .tab { display: none; }
    .tab.active { display: block; }
    .card-grid { display: flex; gap: 20px; flex-wrap: wrap; }
    .card {
      flex: 1; min-width: 220px; background: var(--card);
      padding: 16px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-align: center;
    }
    .card h3 { margin: 0 0 8px; color: var(--primary); }
    .card p { margin: 0; font-size: 20px; font-weight: bold; }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table th, table td {
      padding: 10px;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    /* Subscription Plan Cards Style */
    .subscription-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 24px;
    }

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
    .plan-card button:hover { background: #04690a; }



    /* land for rent css */


/* Image preview container */
.image-preview-container {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-top: 8px;
}

/* Style for each image thumbnail inside preview */
.image-thumb {
  position: relative;
  width: 100px;
  height: 100px;
  border: 1px solid #ccc;
  border-radius: 6px;
  overflow: hidden;
  margin-bottom: 10px;
}

.image-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.remove-image-btn {
  position: absolute;
  top: 2px;
  right: 2px;
  background: rgba(255, 0, 0, 0.7);
  border: none;
  color: white;
  font-weight: bold;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  cursor: pointer;
  line-height: 18px;
  padding: 0;
}

/* Responsive */
/* @media (max-width: 480px) {
  #land-rent {
    padding: 1rem;
  }

  #land-rent h2 {
    font-size: 1.25rem;
  }

  #land-rent button {
    font-size: 0.95rem;
  }
} */

/* end of land for rent */

    
/* laand for sale */


/* Form container */
.form-container {
  background: #fff;
  padding: 24px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  max-width: 800px;
  margin: 0 auto;
  margin-top: 20px;
}

/* Labels */
.form-container label {
  display: block;
  font-weight: 600;
  margin-bottom: 6px;
  margin-top: 16px;
  color: #333;
}

/* Text inputs, number inputs, selects, textarea */
.form-container input[type="text"],
.form-container input[type="number"],
.form-container select,
.form-container textarea {
  width: 100%;
  padding: 10px 12px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-sizing: border-box;
  margin-bottom: 10px;
  transition: border-color 0.3s;
}

.form-container input:focus,
.form-container select:focus,
.form-container textarea:focus {
  border-color: var(--primary, #007BFF);
  outline: none;
}

/* File input */
.form-container input[type="file"] {
  margin-top: 10px;
}


/* Image preview container */
/* .image-preview-container {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-top: 10px;
  margin-bottom: 20px;
}

.image-preview-container img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 6px;
  border: 1px solid #ccc;
} */

/* Submit button */
.form-container button[type="submit"] {
  background: var(--primary, #007BFF);
  color: white;
  padding: 10px 20px;
  margin-top: 20px;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.3s;
}

.form-container button[type="submit"]:hover {
  background: #0056b3;
}

@media (max-width: 768px) {
  .form-container {
    padding: 16px;
    margin-top: 16px;
    max-width: 100%;
  }

  .form-container input[type="text"],
  .form-container input[type="number"],
  .form-container select,
  .form-container textarea {
    font-size: 15px;
    padding: 10px;
  }

  .form-container label {
    font-size: 14px;
    margin-top: 12px;
  }

  .form-container button[type="submit"] {
    width: 100%;
    font-size: 15px;
    padding: 12px;
  }

/*   .image-preview-container {
    justify-content: center;
  }

  .image-preview-container img {
    width: 100px;
    height: 80px;
  } */
}

@media (max-width: 480px) {
  .form-container {
    padding: 14px;
  }

  .form-container button[type="submit"] {
    font-size: 14px;
    padding: 10px;
  }

  .form-container label {
    font-size: 13px;
  }

 /*  .image-preview-container img {
    width: 100px;
    height: 100px;
  } */
}


/* start active view */
/* Filter bar layout */

/* Better Filter Bar Styling */
/* Basic Reset */


.property-container {
  max-width: 1100px;
  margin: auto;
}

.property-filters {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 20px;
}

.property-filters label {
  font-weight: 500;
}

.property-filters select {
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  min-width: 180px;
}

.property-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 16px;
}

.property-card {
  background-color: #fff;
  border-radius: 10px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
  transition: box-shadow 0.3s ease;
  max-height: 360px;
}

.property-card:hover {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.property-image {
  width: 100%;
  height: 180px;
  max-height: 200px;
  object-fit: cover;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.property-detail {
  padding: 12px;
}

.property-detail h3 {
  font-size: 17px;
  margin-bottom: 6px;
  color: #222;
} 

.property-detail .price {
  color: #008000;
  font-weight: bold;
  margin-bottom: 6px;
}

.property-detail .listed-date,
.property-detail .status {
  font-size: 14px;
  color: #555;
  margin-bottom: 4px;
}

.status.available {
  color: #007b00;
  font-weight: 500;
}

/* Mobile layout: image on left, content on right */
@media (max-width: 600px) {
  .property-card {
    flex-direction: row;
    max-height: unset;
    padding:10px;
  }

  .property-image {
    width: 100px;
    height: 100px;
    border-radius: 8px;
    margin: 10px;
    object-fit: cover;
    flex-shrink: 0;
  }

  .property-detail {
    padding: 10px 10px 10px 0;
    flex: 1;
  }

  .property-detail h3 {
    font-size: 16px;
  }

  .property-detail .price {
    font-size: 15px;
  }

  .property-detail .listed-date,
  .property-detail .status {
    font-size: 13px;
  }
}


/* end of active view */


/* pending approval */

/* === FILTER === */
.pending-wrapper .property-filter {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 1rem;
}

.pending-wrapper .property-filter select {
  padding: 0.5rem;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 6px;
}

/* === GRID: 3 COLUMNS DESKTOP === */
.pending-wrapper .pending-properties {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}

/* === CARD === */
.pending-wrapper .property-card {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  transition: transform 0.2s ease;
  display: flex;
  flex-direction: column;
}

.pending-wrapper .property-card:hover {
  transform: translateY(-2px);
}

.pending-wrapper .property-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.pending-wrapper .property-info {
  padding: 1rem;
}

.pending-wrapper .property-info h3 {
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
}

.pending-wrapper .price {
  font-weight: bold;
  margin: 0.25rem 0;
}

.pending-wrapper .status {
  color: #b37400;
  font-weight: 600;
}

.pending-wrapper .listed-date {
  font-size: 0.9rem;
  color: #777;
}

.pending-wrapper .rejection-message {
  margin-top: 0.5rem;
  background: #ffe6e6;
  color: #a30000;
  padding: 6px;
  border-radius: 5px;
  font-size: 0.85rem;
}

.pending-wrapper .action-buttons {
  margin-top: 0.7rem;
  display: flex;
  gap: 0.5rem;
}

.edit-btn,
.delete-btn {
  padding: 6px 12px;
  font-size: 0.85rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.edit-btn {
  background: #ffd966;
}

.delete-btn {
  background: #f44336;
  color: #fff;
}

/* === MOBILE: STACKED CARDS WITH IMAGE LEFT === */
@media screen and (max-width: 768px) {
  .pending-wrapper .pending-properties {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .pending-wrapper .property-card {
    flex-direction: row;
    align-items: flex-start;
    gap: 0.75rem;
  }

  .pending-wrapper .property-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    flex-shrink: 0;
    border-radius: 6px 0 0 6px;
  }

  .pending-wrapper .property-info {
    padding: 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .pending-wrapper .property-info h3 {
    font-size: 1rem;
    margin: 0;
  }

  .pending-wrapper .price,
  .pending-wrapper .status,
  .pending-wrapper .listed-date,
  .pending-wrapper .rejection-message {
    font-size: 0.85rem;
    margin: 2px 0;
  }

  .pending-wrapper .action-buttons {
    flex-wrap: wrap;
  }
}


/* approval */

/* end of land for sale */
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        transform: translateX(-220px);
        top: 50px;
        left: 0;
        height: 100%;
        width: 220px;
        transition: transform 0.3s ease;
        z-index: 1000;
      }
      .sidebar.open {
        transform: translateX(0);
      }

      .hamburger {
        display: block;
        cursor: pointer;
      }
      .hamburger span {
        display: block;
        width: 30px;
        height: 4px;
        background: #333;
        margin: 6px auto;
        transition: all 0.3s;
      }
      
      .subscription-container {
        flex-direction: column;
        gap: 16px;
      }

      .plan-card {
        min-width: 100%;
        padding: 16px;
      }

      #plans {
        display: block;
        margin-top: 20px;
        text-align: center;
      }

      #showPlansBtn {
        margin: 0 auto;
        padding: 12px 24px;
        display: block;
      }

    
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
#home{
  margin-top: 50px
 
  }

  .property-container{
    margin-top: 50px; 
  }

  .pending-wrapper {
    margin-top: 50px; 
  }

  #subscription{
    margin-top: 50px;
  }

  #profile{
    margin-top: 50px;
  }
}
  </style>
</head>
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
        <div class="card"><h3>Total Uploads</h3><p>—</p></div>
        <div class="card"><h3>Pending Approval</h3><p>—</p></div>
      </div>
    </div>

    <!-- Add Tab -->
    <div id="add" class="tab">
      <div id="add-default-message">
        <h1>Add Properties</h1>
        <p>Select a category from the sidebar submenu.</p>
      </div>

      <!-- Form: Land for Sale -->
      <div id="land-sale" class="form-container" style="display:none;">
        <h2>Land for Sale</h2>
        


        <form id="landSaleForm">
    <label for="titleSale">Title:</label>
    <input type="text" id="titleSale" name="title" required />

    <label for="facilitiesSale">Facilities:</label>
    <textarea id="facilitiesSale" name="facilities" placeholder="List available facilities, e.g., electricity, water, fencing..." rows="3"></textarea>

    <label for="descriptionSale">Description:</label>
    <textarea id="descriptionSale" name="description" required></textarea>

    <label for="stateSale">State:</label>
    <select id="stateSale" name="state" required></select>

    <label for="lgaSale">LGA:</label>
    <select id="lgaSale" name="lga" required></select>

    <label for="addressSale">Address:</label>
    <input type="text" id="addressSale" name="address" required />

    <label for="sizeSale">Size (in sq meters):</label>
    <input type="number" id="sizeSale" name="size" min="1" required />

    <label for="priceSale">Price (₦):</label>
    <input type="number" id="priceSale" name="price" min="0" required />

    <label for="categorySale">Category:</label>
    <select id="categorySale" name="category" required>
      <option value="">Select category</option>
      <option value="residential">Residential</option>
      <option value="commercial">Commercial</option>
    </select>

    <div id="imagePreview2" class="image-preview-container"></div>

    <label for="images2">Upload Images:</label>
    <input type="file" id="images2" name="images2" multiple accept="image/*" />

    <button type="submit">Add Land for Sale</button>
  </form>
      </div>

      <!-- Form: Land for Rent -->
      <div id="land-rent" class="form-container" style="display:none;">
        <h2>Land for Rent</h2>
        <form>
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" required />

          <label for="propertyTypeRent">Property Type:</label>
          <input type="text" id="propertyTypeRent" name="propertyType" placeholder="e.g., Farm," required />

          <label for="description">Description:</label>
          <textarea id="description" name="description" required></textarea>

          <label for="state">State:</label>
          <select id="state" name="state" required></select>

          <label for="lga">LGA:</label>
          <select id="lga" name="lga" required></select>

          <label for="address">Address:</label>
          <input type="text" id="address" name="address" required />

          <label for="size">Size (in sq meters):</label>
          <input type="number" id="size" name="size" min="1" required />

          <label for="rentPrice">Price (₦):</label>
          <input type="number" id="rentPrice" name="rentPrice" min="0" required />

          <label for="category">Category:</label>
          <select id="category" name="category" required>
            <option value="">Select category</option>
            <option value="residential">Residential</option>
            <option value="commercial">Commercial</option>
          </select>

          <label for="duration">Duration for Rent:</label>
          <input type="text" id="duration" name="duration" placeholder="e.g., 3 months, 2 weeks" required />

          <label for="facilitiesSale">Facilities:</label>
          <textarea id="facilitiesSale" name="facilities" placeholder="List available facilities, e.g., electricity, water, fencing..." rows="3"></textarea>

          <div id="imagePreview1" class="image-preview-container"></div>

          <label for="images1">Upload Images:</label>
          <input type="file" id="images1" name="images1" multiple accept="image/*" />

          <button type="submit">Add Land for Rent</button>
        </form>
      </div>



    <!--start property for sale -->

<div id="property-sale" class="form-container" style="display: none;">
  <h2>Property for Sale</h2>
  <form class="property-sale-form">
    <label for="titleSale">Title:</label>
    <input type="text" id="titleSale" name="title" required />

    <label for="descriptionSale">Description:</label>
    <textarea id="descriptionSale" name="description" required></textarea>

    <label for="state_sale">State:</label>
    <select id="state_sale" name="state" required></select>

    <label for="lga_sale">LGA:</label>
    <select id="lga_sale" name="lga" required></select>

    <label for="addressSale">Address:</label>
    <input type="text" id="addressSale" name="address" required />

    <label for="sizeSale">Size (in sq meters):</label>
    <input type="number" id="sizeSale" name="size" min="1" required />

    <label for="priceSale">Price (₦):</label>
    <input type="number" id="priceSale" name="price" min="0" required />

    <label for="conditionSale">Condition:</label>
    <select id="conditionSale" name="condition" required>
      <option value="">Select condition</option>
      <option value="used">Used</option>
      <option value="fairly_used">Fairly Used</option>
      <option value="newly_built">Newly Built</option>
    </select>

    <label for="furnishedSale">Furnished:</label>
    <select id="furnishedSale" name="furnished" required>
      <option value="">Select furnishing</option>
      <option value="furnished">Furnished</option>
      <option value="semi_furnished">Semi Furnished</option>
      <option value="unfurnished">Unfurnished</option>
    </select>

    <label for="propertyTypeSale">Property Type:</label>
    <input type="text" id="propertyTypeSale" name="propertyType" placeholder="e.g., Office, Apartment" required />

    <label for="durationSale">Duration (e.g., 6 months, 1 year):</label>
    <input type="text" id="durationSale" name="duration" required />

    <label for="facilitiesSale">Facilities:</label>
    <textarea id="facilitiesSale" name="facilities" placeholder="List facilities like electricity, water, security..." rows="3"></textarea>

    <label for="bedroomsSale">Number of Bedrooms:</label>
    <input type="number" id="bedroomsSale" name="bedrooms" min="0" required />

    <label for="bathroomsSale">Number of Bathrooms:</label>
    <input type="number" id="bathroomsSale" name="bathrooms" min="0" required />

    <div id="imagePreview4" class="image-preview-container"></div>

    <label for="images4">Upload Images:</label>
    <input type="file" id="images4" name="images4" multiple accept="image/*" />

    <button type="submit">Add Property for Sale</button>
  </form>
</div>

    <!--end  property for sale  -->




<!-- property for rent -->
    <div id="property-rent" class="form-container property-rent-form" style="display: none;">
  <h2>Property for Rent</h2>
  <form>
    <label for="titleRent">Title:</label>
    <input type="text" id="titleRent" name="title" required />

    <label for="descriptionRent">Description:</label>
    <textarea id="descriptionRent" name="description" required></textarea>

    <label for="stateRent">State:</label>
    <select id="stateRent" name="state" required></select>

    <label for="lgaRent">LGA:</label>
    <select id="lgaRent" name="lga" required></select>

    <label for="addressRent">Address:</label>
    <input type="text" id="addressRent" name="address" required />

    <label for="sizeRent">Size (in sq meters):</label>
    <input type="number" id="sizeRent" name="size" min="1" required />

    <label for="priceRent">Price (₦):</label>
    <input type="number" id="priceRent" name="price" min="0" required />

    <label for="conditionRent">Condition:</label>
    <select id="conditionRent" name="condition" required>
      <option value="">Select condition</option>
      <option value="used">Used</option>
      <option value="fairly_used">Fairly Used</option>
      <option value="newly_built">Newly Built</option>
    </select>

    <label for="furnishedRent">Furnished:</label>
    <select id="furnishedRent" name="furnished" required>
      <option value="">Select furnishing</option>
      <option value="furnished">Furnished</option>
      <option value="semi_furnished">Semi Furnished</option>
      <option value="unfurnished">Unfurnished</option>
    </select>

    <label for="propertyTypeRent">Property Type:</label>
    <input type="text" id="propertyTypeRent" name="propertyType" placeholder="e.g., Office, Apartment" required />

    <label for="durationRent">Duration (e.g., 6 months, 1 year):</label>
    <input type="text" id="durationRent" name="duration" required />

    <label for="facilitiesRent">Facilities:</label>
    <textarea id="facilitiesRent" name="facilities" placeholder="List facilities like electricity, water, security..." rows="3"></textarea>

    <label for="bedroomsRent">Number of Bedrooms:</label>
    <input type="number" id="bedroomsRent" name="bedrooms" min="0" required />

    <label for="bathroomsRent">Number of Bathrooms:</label>
    <input type="number" id="bathroomsRent" name="bathrooms" min="0" required />

    <div id="imagePreview3" class="image-preview-container"></div>

    <label for="images3">Upload Images:</label>
    <input type="file" id="images3" name="images3" multiple accept="image/*" />

    <button type="submit">Add Property for Rent</button>
  </form>
</div>
<!-- properiety for sale -->


<!-- start shortlet -->
<div id="shortlet" class="form-container" style="display: none;">
  <h2>Property for Shortlet</h2>
  <form class="shortlet-form">
    <label for="titleShortlet">Title:</label>
    <input type="text" id="titleShortlet" name="title" required />

    <label for="descriptionShortlet">Description:</label>
    <textarea id="descriptionShortlet" name="description" required></textarea>

    <label for="statelet">State:</label>
    <select id="statelet" name="state" required></select>

    <label for="lgalet">LGA:</label>
    <select id="lgalet" name="lga" required></select>

    <label for="addressShortlet">Address:</label>
    <input type="text" id="addressShortlet" name="address" required />

    <label for="priceShortlet">Price (₦):</label>
    <input type="number" id="priceShortlet" name="price" min="0" required />

    <label for="durationShortlet">Duration (e.g., 3 nights, 1 week):</label>
    <input type="text" id="durationShortlet" name="duration" required />

    <label for="conditionShortlet">Condition:</label>
    <select id="conditionShortlet" name="condition" required>
      <option value="">Select condition</option>
      <option value="used">Used</option>
      <option value="fairly_used">Fairly Used</option>
      <option value="newly_built">Newly Built</option>
    </select>

    <label for="furnishedShortlet">Furnished:</label>
    <select id="furnishedShortlet" name="furnished" required>
      <option value="">Select furnishing</option>
      <option value="furnished">Furnished</option>
      <option value="semi_furnished">Semi Furnished</option>
      <option value="unfurnished">Unfurnished</option>
    </select>

    <label for="smokingShortlet">Smoking Allowed?</label>
    <select id="smokingShortlet" name="smoking" required>
      <option value="">Select</option>
      <option value="yes">Yes</option>
      <option value="no">No</option>
    </select>

    <label for="parkingShortlet">Parking Available?</label>
    <select id="parkingShortlet" name="parking" required>
      <option value="">Select</option>
      <option value="yes">Yes</option>
      <option value="no">No</option>
    </select>

    <label for="facilitiesShortlet">Facilities:</label>
    <textarea id="facilitiesShortlet" name="facilities" placeholder="e.g., electricity, Wi-Fi, water..." rows="3"></textarea>

    <label for="bedroomsShortlet">Number of Rooms:</label>
    <input type="number" id="bedroomsShortlet" name="bedrooms" min="0" required />

    <label for="bathroomsShortlet">Number of Bathrooms:</label>
    <input type="number" id="bathroomsShortlet" name="bathrooms" min="0" required />

    <div id="imagePreview5" class="image-preview-container"></div>

    <label for="images5">Upload Images:</label>
    <input type="file" id="images5" name="images5" multiple accept="image/*" />

    <button type="submit">Add Property for Shortlet</button>
  </form>
</div>

<!--end shortlet -->


<!-- decor form -->
<!-- Decor Form -->
<div id="decor" class="form-container" style="display: none;">
  <h2>Decor</h2>
  <form class="decor-form">
    <label for="decorName">Name:</label>
    <input type="text" id="decorName" name="title" required />

    <label for="decorDescription">Description:</label>
    <textarea id="decorDescription" name="description" required></textarea>

    <label for="decorState">State:</label>
    <select id="decorState" name="state" required></select>

    <label for="decorLga">LGA:</label>
    <select id="decorLga" name="lga" required></select>

    <label for="decorAddress">Address:</label>
    <input type="text" id="decorAddress" name="address" required />

    <label for="decorPrice">Price (₦):</label>
    <input type="number" id="decorPrice" name="price" min="0" required />

    <label for="decorType">Type of Decor:</label>
    <select id="decorType" name="type" required>
      <option value="">Select type</option>
      <option value="interior">Interior Decor</option>
      <option value="exterior">Exterior Decor</option>
    </select>

    <div id="decorImagePreview" class="image-preview-container"></div>

    <label for="decorImages">Upload Images:</label>
    <input type="file" id="decorImages" name="decorImages[]" multiple accept="image/*" />

    <button type="submit">Add Decor Listing</button>
  </form>
</div>


<!-- decor form -->


<!-- building material -->

<!-- Building Material Form -->
<div id="building-material" class="form-container" style="display: none;">
  <h2>Building Material</h2>
  <form class="building-form">
    <label for="materialName">Name:</label>
    <input type="text" id="materialName" name="title" required />

    <label for="materialDescription">Description:</label>
    <textarea id="materialDescription" name="description" required></textarea>

    <label for="materialState">State:</label>
    <select id="materialState" name="state" required></select>

    <label for="materialLga">LGA:</label>
    <select id="materialLga" name="lga" required></select>

    <label for="materialAddress">Address:</label>
    <input type="text" id="materialAddress" name="address" required />

    <label for="materialPrice">Price (₦):</label>
    <input type="number" id="materialPrice" name="price" min="0" required />

    <label for="materialCondition">Condition:</label>
    <select id="materialCondition" name="condition" required>
      <option value="">Select type</option>
      <option value="imported">Foreign</option>
      <option value="used">Used</option>
      <option value="new">Newly Manufactured</option>
    </select>

    <div id="materialImagePreview" class="image-preview-container"></div>

    <label for="materialImages">Upload Images:</label>
    <input type="file" id="materialImages" name="materialImages[]" multiple accept="image/*" />

    <button type="submit">Add Building Material</button>
  </form>
</div>

<!-- end of building material -->


    </div>



<!-- view active start -->
<!-- Active Properties View -->




<!-- view active start -->

    <!-- Profile Tab -->
    <div id="profile" class="tab">
      <h2>User Profile</h2>

      <div class="profile-tabs">
        <button class="profile-tab-btn active" data-profile-tab="view">👁️ View</button>
        <button class="profile-tab-btn" data-profile-tab="update">🔒 Update Password</button>
      </div>

      <div id="profile-view" class="profile-tab-content active">
        <label>Name:</label>
        <input type="text" value="John Doe" readonly>

        <label>Phone:</label>
        <input type="text" value="+234123456789" readonly>

        <label>Email:</label>
        <input type="email" value="john@example.com" readonly>

        <label>Password:</label>
        <input type="password" value="********" readonly>
      </div>

      <div id="profile-update" class="profile-tab-content">
        <label>Current Password:</label>
        <input type="password" placeholder="Enter current password">

        <label>New Password:</label>
        <input type="password" placeholder="Enter new password">

        <button type="submit">Update Password</button>
      </div>
    </div>

    <!-- View Tab -->
   <div id="view" class="tab">

  <!-- ✅ ACTIVE PROPERTIES SECTION -->
  <div id="active" class="status-list" style="display: none;">
    <div class="property-container">

      <!-- 🔍 Category Filter -->
      <div class="property-filters">
        <label for="categoryFilter">Filter by Category:</label>
        <select id="categoryFilter">
          <option value="all">All Categories</option>
          <option value="land-sale">Land for Sale</option>
          <option value="land-rent">Land for Rent</option>
          <option value="property-sale">Property for Sale</option>
          <option value="property-rent">Property for Rent</option>
          <option value="shortlet">Shortlet</option>
          <option value="decor">Decor</option>
          <option value="building-material">Building Material</option>
        </select>
      </div>

      <!-- 🧱 Active Cards Grid -->
      <div class="property-grid">
        <div class="property-card" data-category="shortlet">
          <img src="NEW.jpeg" alt="Property Image" class="property-image" />
          <div class="property-detail">
            <h3>3 Bedroom Flat</h3>
            <p class="price">₦15,000</p>
            <p class="listed-date">Listed: 2025-07-01</p>
            <p class="status available">Status: Available</p>
            
          </div>
        </div>

        <div class="property-card" data-category="land-sale">
          <img src="https://via.placeholder.com/300x200" alt="Property Image" class="property-image" />
          <div class="property-detail">
            <p class="price">₦5,000,000</p>
            <p class="listed-date">Listed: 2025-07-04</p>
            <p class="status available">Status: Available</p>
          </div>
        </div>

        <!-- Add more cards as needed -->
      </div>
   
      </div>

      </div>


  

  <!-- ✅ PENDING APPROVAL SECTION -->
<div id="pending" class="pending-wrapper" style="display: none;">
  <!-- Filter -->
  <div class="property-filter">
    <select id="pendingCategoryFilter">
      <option value="">All Categories</option>
      <option value="land">Land</option>
      <option value="property">Property</option>
      <option value="shortlet">Shortlet</option>
      <option value="decor">Decor</option>
      <option value="building">Building Material</option>
    </select>
  </div>
  <!-- Property Cards -->

  
  <div class="pending-properties">
    <div class="property-card">
      <img src="your-image.jpg" alt="Property Image" class="property-image" />
      <div class="property-info">
        <h3>3 Bedroom Flat</h3>
        <p class="price">₦15,000</p>
        <p class="status">Status: Pending</p>
        <p class="listed-date">Listed: 2025-07-01</p>
        <div class="rejection-message">❗Wrong pictures and missing details</div>
        <div class="action-buttons">
          <button class="edit-btn">✏️ Edit</button>
          <button class="delete-btn">🗑️ Delete</button>
        </div>
      </div>
    </div>
  <div class="property-card">
      <img src="your-image.jpg" alt="Property Image" class="property-image" />
      <div class="property-info">
        <h3>3 Bedroom Flat</h3>
        <p class="price">₦15,000</p>
        <p class="status">Status: Pending</p>
        <p class="listed-date">Listed: 2025-07-01</p>
        <div class="rejection-message">❗Wrong pictures and missing details</div>
        <div class="action-buttons">
          <button class="edit-btn">✏️ Edit</button>
          <button class="delete-btn">🗑️ Delete</button>
        </div>
      </div>
    </div>

  </div>
</div>

   </div>

   <!-- approval -->

    <!-- Subscription Tab -->
    <div id="subscription" class="tab">
      <h1>Subscription Details</h1>
      <div class="card-grid">
        <div class="card">
          <h3>Plan Type</h3>
          <p>Pro</p>
        </div>
        <div class="card">
          <h3>Date of Subscription</h3>
          <p>July 1, 2025</p>
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
</div>


<script>

  /* start scription js  */
   document.getElementById("showPlansBtn").addEventListener("click", function() {
    const plans = document.getElementById("plans");
    plans.style.display = plans.style.display === "none" ? "block" : "none";
  }); 

  /* end subcription js */

// Handle tab button clicks (like "Add Properties", "View Property", "Home", "Subscription")
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const tabId = btn.getAttribute('data-tab');
    const tabContent = document.getElementById(tabId);

    // Show the clicked tab content
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    if (tabContent) tabContent.classList.add('active');

    // Hide all other submenus
    document.querySelectorAll('.submenu').forEach(sub => {
      if (sub !== btn.parentElement.querySelector('.submenu')) {
        sub.style.display = 'none';
      }
    });

    // Toggle submenu ONLY for 'add' or 'view'
    const submenu = btn.parentElement.querySelector('.submenu');
    if (tabId === 'add' || tabId === 'view') {
      if (submenu) {
        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
      }
    } else {
      // ✅ For all other tabs like "home", "subscription", close sidebar on mobile
      if (window.innerWidth < 768) {
        document.getElementById('sidebar').classList.remove('open');
      }
    }
  });
});

// Handle submenu button clicks (like "Land for Sale", etc.)
document.querySelectorAll('.submenu-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    // Hide default message
    const defaultMessage = document.getElementById('add-default-message');
    if (defaultMessage) defaultMessage.style.display = 'none';

    // Hide all forms
    document.querySelectorAll('.form-container').forEach(form => {
      form.style.display = 'none';
    });

    // Show the selected form
    const formId = btn.getAttribute('data-form');
    const form = document.getElementById(formId);
    if (form) form.style.display = 'block';

    // ✅ Close sidebar on mobile
    if (window.innerWidth < 768) {
      document.getElementById('sidebar').classList.remove('open');
    }
  });
});

// Sidebar & theme toggle
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
}

function toggleTheme() {
  document.documentElement.setAttribute(
    'data-theme',
    document.getElementById('themeToggle').checked ? 'dark' : 'light'
  );
}





// === Populate State and LGA Dropdown ===
const nigeriaStatesLGAs = {
  "Abia": ["Aba North","Aba South","Isiala Ngwa North","Isiala Ngwa South","Obi Ngwa","Ugwunagbo","Osisioma","Ukwa East","Ukwa West","Ikwuano","Umuahia North","Umuahia South","Ohafia"],
  "Adamawa": ["Demsa","Fufore","Ganye","Gayuk","Gombi","Grie","Hong","Jada","Lamurde","Madagali","Maiha","Mayo Belwa","Michika","Mubi North","Mubi South","Numan","Shelleng","Song","Toungo","Yola North","Yola South"],
  "Akwa Ibom": ["Abak","Eastern Obolo","Eket","Esit Eket","Essien Udim","Etim Ekpo","Etinan","Ibeno","Ibesikpo Asutan","Ibiono-Ibom","Ika","Ikono","Ikot Abasi","Ikot Ekpene","Ini","Itu","Mbo","Mkpat-Enin","Nsit-Atai","Nsit-Ibom","Nsit-Ubium","Obot Akara","Okobo","Onna","Oron","Oruk Anam","Udung-Uko","Ukanafun","Uruan","Urue-Offong/Oruko","Uyo"],
  "Anambra": ["Aguata","Anambra East","Anambra West","Anaocha","Awka North","Awka South","Ayamelum","Dunukofia","Ekwusigo","Idemili North","Idemili South","Ihiala","Njikoka","Nnewi North","Nnewi South","Ogbaru","Onitsha North","Onitsha South","Orumba North","Orumba South","Oyi"],
  "Bauchi": ["Alkaleri","Bogoro","Damban","Darazo","Dass","Gamawa","Ganjuwa","Giade","Itas/Gadau","Jama’are","Katagum","Kirfi","Misau","Ningi","Shira","Tafawa Balewa","Toro","Warji","Zaki"],
  "Bayelsa": ["Brass","Ekeremor","Kolokuma/Opokuma","Nembe","Ogbia","Sagbama","Southern Ijaw","Yenagoa"],
  "Benue": ["Ado","Agatu","Apa","Buruku","Gboko","Guma","Gwer East","Gwer West","Katsina-Ala","Konshisha","Kwande","Logo","Makurdi","Ogbadibo","Oju","Okpokwu","Otukpo","Tarka","Ukum","Ushongo","Vandeikya"],
  "Borno": ["Abadam","Askira/Uba","Bama","Bayo","Biu","Chibok","Damboa","Dikwa","Gubio","Guzamala","Gwoza","Hawul","Jere","Kaga","Kala/Balge","Konduga","Kukawa","Kwaya Kusar","Mafa","Magumeri","Maiduguri","Marte","Mobbar","Monguno","Ngala","Nganzai","Shani"],
  "Cross River": ["Akamkpa","Biase","Bekwarra","Calabar Municipal","Calabar South","Etung","Ikom","Obanliku","Obubra","Obudu","Odukpani","Ogoja","Yakuur","Yala"],
  "Delta": ["Abraka","Aniocha North","Aniocha South","Bomadi","Burutu","Ethiope East","Ethiope West","Ika North-East","Ika South","Isoko North","Isoko South","Ndokwa East","Ndokwa West","Okpe","Oshimili North","Oshimili South","Patani","Sapele","Udu","Ughelli North","Ughelli South","Ukwuani","Uvwie","Warri North","Warri South","Warri South West"],
  "Ebonyi": ["Abakaliki","Afikpo North","Afikpo South","Ebonyi","Ezza North","Ezza South","Ikwo","Ishielu","Ivo","Izzi","Ohaozara","Ohaukwu","Onicha"],
  "Edo": ["Akoko-Edo","Egor","Esan Central","Esan North-East","Esan South-East","Esan West","Etsako Central","Etsako East","Etsako West","Igueben","Ikpoba-Okha","Oredo","Orhionmwon","Ovia North-East","Ovia South-West","Owan East","Owan West","Uhunmwonde"],
  "Ekiti": ["Ado-Ekiti","Efon","Ekiti East","Ekiti South-West","Ekiti West","Emure","Gbonyin","Ido-Osi","Ijero","Ikere","Ikole","Ilejemeje","Irepodun/Ifelodun","Ise/Orun","Moba","Oye"],
  "Enugu": ["Aninri","Awgu","Enugu East","Enugu North","Enugu South","Ezeagu","Igbo-Etiti","Igboeze North","Isi-Uzo","Nkanu East","Nkanu West","Nsukka","Oji River","Udenu","Udi","Uzo-Uwani"],
  "Gombe": ["Akko","Balanga","Billiri","Dukku","Funakaye","Gombe","Kaltungo","Kwami","Nafada","Shongom","Yalmatu/Deba"],
  "Imo": ["Aboh Mbaise","Ahiazu Mbaise","Ehime Mbano","Ezinihitte","Ideato North","Ideato South","Ihitte/Uboma","Ikeduru","Isiala Mbano","Isu","Mbaitoli","Ngor Okpala","Njaba","Nkwerre","Nwangele","Obowo","Oguta","Ohaji/Egbema","Okigwe","Orlu","Orsu","Oru East","Oru West","Owerri Municipal","Owerri North","Owerri West"],
  "Jigawa": ["Auyo","Babura","Biriniwa","Birnin Kudu","Buji","Dutse","Gagarawa","Garki","Gumel","Guri","Gwaram","Gwiwa","Hadejia","Jahun","Kafin Hausa","Kaugama","Kazaure","Kiri Kasama","Kiyawa","Maigatari","Malam Madori","Miga","Ringim","Roni","Sule Tankarkar","Taura","Yankwashi"],
  "Kaduna": ["Birnin-Gwari","Chikun","Giwa","Igabi","Ikara","Jaba","Jema’a","Kachia","Kaduna North","Kaduna South","Kagarko","Kajuru","Kaura","Kauru","Kubau","Kudan","Lere","Makarfi","Sabon Gari","Sanga","Soba","Zangon Kataf","Zaria"],
  "Kano": ["Ajingi","Albasu","Bagwai","Bebeji","Bichi","Bunkure","Dala","Dambatta","Dawakin Kudu","Dawakin Tofa","Doguwa","Fagge","Gabasawa","Garko","Garun Mallam","Gaya","Gezawa","Gwale","Gwarzo","Kabo","Kano Municipal","Kumbotso","Kunchi","Kura","Madobi","Makoda","Minjibir","Nasarawa","Rano","Rimin Gado","Rogo","Shanono","Sumaila","Takai","Tarauni","Tofa","Tsanyawa","Tudun Wada","Ungogo","Warawa","Wudil"],
  "Katsina": ["Bakori","Batagarawa","Batsari","Baure","Bindawa","Charanchi","Dandume","Danja","Dan Musa","Daura","Dutsi","Dutsin-Ma","Faskari","Funtua","Ingawa","Jibia","Kafur","Kaita","Kankara","Kankia","Katsina","Kurfi","Kusada","Mai’Adua","Malumfashi","Mani","Mashi","Matazu","Musawa","Rimi","Sabuwa","Safana","Sandamu","Zango"],
  "Kebbi": ["Aleiro","Arewa Dandi","Argungu","Augie","Bagudo","Birnin Kebbi","Bunza","Dandi","Fakai","Gwandu","Jega","Kalgo","Koko/Besse","Maiyama","Ngaski","Sakaba","Shanga","Suru","Wasagu/Danko","Yauri","Zuru"],
  "Kogi": ["Adavi","Ajaokuta","Ankpa","Bassa","Dekina","Ibaji","Idah","Igalamela-Odolu","Ijumu","Kabba/Bunu","Kogi","Lokoja","Mopa-Muro","Ofu","Ogori/Magongo","Okehi","Okene","Olamaboro","Omala","Yagba East","Yagba West"],
  "Kwara": ["Asa","Baruten","Edu","Ekiti","Ifelodun","Ilorin East","Ilorin South","Ilorin West","Irepodun","Isin","Kaiama","Moro","Offa","Oke-Ero","Oyun","Pategi"],
  "Lagos": ["Agege","Ajeromi-Ifelodun","Alimosho","Amuwo-Odofin","Apapa","Badagry","Epe","Eti-Osa","Ibeju-Lekki","Ifako-Ijaiye","Ikeja","Ikorodu","Kosofe","Lagos Island","Lagos Mainland","Mushin","Ojo","Oshodi-Isolo","Shomolu","Surulere"],
  "Nasarawa": ["Akwanga","Awe","Doma","Karu","Keana","Keffi","Kokona","Lafia","Nasarawa","Nasarawa-Eggon","Obi","Toto","Wamba"],
  "Niger": ["Agaie","Agwara","Bida","Borgu","Bosso","Chanchaga","Edati","Gbako","Gurara","Katcha","Kontagora","Lapai","Lavun","Magama","Mariga","Mashegu","Mokwa","Moya","Paikoro","Rafi","Rijau","Shiroro","Suleja","Tafa","Wushishi"],
  "Ogun": ["Abeokuta North","Abeokuta South","Ado-Odo/Ota","Ewekoro","Ifo","Ijebu East","Ijebu North","Ijebu North East","Ijebu Ode","Ikenne","Imeko-Afon","Ipokia","Odogbolu","Ogun Waterside","Remo North","Sagamu"],
  "Ondo": ["Akoko North-East","Akoko North-West","Akoko South-East","Akoko South-West","Akure North","Akure South","Ese Odo","Idanre","Ifedore","Ilaje","Ile Oluji/Okeigbo","Irele","Odigbo","Okitipupa","Ondo East","Ondo West","Ose","Owo"],
  "Osun": ["Atakunmosa East","Atakunmosa West","Aiyedire","Boluwaduro","Boripe","Ede North","Ede South","Egbedore","Ejigbo","Ife Central","Ife East","Ife North","Ife South","Ifelodun","Ila","Ilesa East","Ilesa West","Irepodun","Irewole","Isokan","Iwo","Obokun","Odo Otin","Ola Oluwa","Olorunda","Oriade","Orolu","Osogbo"],
  "Oyo": ["Afijio","Akinyele","Atiba","Atisbo","Egbeda","Ibadan North","Ibadan North-East","Ibadan North-West","Ibadan South-East","Ibadan South-West","Ibarapa Central","Ibarapa East","Ibarapa North","Ido","Irepo","Iseyin","Itesiwaju","Iwajowa","Kajola","Lagelu","Ogbomosho North","Ogbomosho South","Ogo Oluwa","Olorunsogo","Oluyole","Ona Ara","Orelope","Ori Ire","Oyo East","Oyo West","Saki East","Saki West","Surulere"],  
  "Plateau": ["Barkin Ladi","Bassa","Bokkos","Jos East","Jos North","Jos South","Kanam","Kanke","Langtang North","Langtang South","Mangu","Mikang","Pankshin","Qua’an Pan","Riyom","Shendam","Wase"],
  "Rivers": ["Abua–Odual","Ahoada East","Ahoada West","Akuku-Toru","Andoni","Asari-Toru","Bonny","Degema","Emohua","Eleme","Etche","Gokana","Ikwerre","Khana","Obio/Akpor","Ogba–Egbema–Ndoni","Ogu–Bolo","Okrika","Omuma","Opobo–Nkoro","Oyigbo","Port Harcourt"],
  "Sokoto": ["Binji","Bodinga","Dange Shuni","Gada","Goronyo","Gudu","Gwadabawa","Illela","Isa","Kebbe","Kware","Rabah","Sabon Birni","Shagari","Silame","Sokoto North","Sokoto South","Tambuwal","Tangaza","Tureta","Wamako","Wurno","Yabo"],
  "Taraba": ["Ardo-Kola","Bali","Donga","Gashaka","Gassol","Ibi","Jalingo","Karim-Lamido","Kumi","Lau","Sardauna","Takum","Ussa","Wukari","Yorro","Zing"],
  "Yobe": ["Bade","Bursari","Damaturu","Fika","Fune","Geidam","Gujba","Gulani","Jakusko","Karasuwa","Machina","Nangere","Nguru","Potiskum","Tarmuwa","Yunusari","Yusufari"],
  "Zamfara": ["Anka","Bakura","Birnin Magaji/Kiyaw","Bungudu","Gummi","Gusau","Isa","Kaura Namoda","Maradun","Maru","Shinkafi","Talata Mafara","Chafe","Zurmi"],
  "FCT": ["Abaji","Bwari","Gwagwalada","Kuje","Kwali","Municipal Area Council"]
}


function populateStateAndLGA(stateSelect, lgaSelect) {
  if (!stateSelect || !lgaSelect) return;

  // Populate states dropdown
  stateSelect.innerHTML = '<option value="">Select State</option>';
  lgaSelect.innerHTML = '<option value="">Select LGA</option>';

  Object.keys(nigeriaStatesLGAs).forEach(state => {
    const option = document.createElement('option');
    option.value = state;
    option.textContent = state;
    stateSelect.appendChild(option);
  });

  // When state changes, update LGA dropdown
  stateSelect.addEventListener('change', () => {
    const selectedState = stateSelect.value;
    lgaSelect.innerHTML = '<option value="">Select LGA</option>';

    if(selectedState && nigeriaStatesLGAs[selectedState]) {
      nigeriaStatesLGAs[selectedState].forEach(lga => {
        const option = document.createElement('option');
        option.value = lga;
        option.textContent = lga;
        lgaSelect.appendChild(option);
      });
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  // Find all state & LGA dropdown pairs by class or ids
  // Example with explicit IDs:
  populateStateAndLGA(document.getElementById('state'), document.getElementById('lga'));
  populateStateAndLGA(document.getElementById('stateSale'), document.getElementById('lgaSale'));
   populateStateAndLGA(document.getElementById('stateRent'), document.getElementById('lgaRent'));
     populateStateAndLGA(document.getElementById('state_sale'), document.getElementById('lga_sale'));
      populateStateAndLGA(document.getElementById('statelet'), document.getElementById('lgalet'));
          populateStateAndLGA(document.getElementById('decorState'), document.getElementById('decorLga'));
            populateStateAndLGA(document.getElementById('materialState'), document.getElementById('materialLga'));







  // Add more as needed
});

/* END OF STATES/ LGA */



// === Image uploader setup ===
function setupImageUploader(inputId, previewId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);
  if (!input || !preview) return;

  const uploadedImages = new Set();

  input.addEventListener('change', () => {
    const files = Array.from(input.files);
    files.forEach(file => {
      const fileKey = file.name + file.size;
      if (uploadedImages.has(fileKey)) return;

      uploadedImages.add(fileKey);

      const reader = new FileReader();
      reader.onload = e => {
        const wrapper = document.createElement('div');
        wrapper.className = 'image-thumb';

        const img = document.createElement('img');
        img.src = e.target.result;

        const btn = document.createElement('button');
        btn.className = 'remove-image-btn';
        btn.innerText = '×';
        btn.onclick = () => {
          wrapper.remove();
          uploadedImages.delete(fileKey);
        };

        wrapper.appendChild(img);
        wrapper.appendChild(btn);
        preview.appendChild(wrapper);
      };

      reader.readAsDataURL(file);
    });

    input.value = ''; // Reset input for re-uploading same file
  });
}

// Initialize for all pairs
setupImageUploader('images1', 'imagePreview1');
setupImageUploader('images2', 'imagePreview2');
setupImageUploader('images3', 'imagePreview3');
setupImageUploader('images4', 'imagePreview4');
setupImageUploader('images5', 'imagePreview5');
setupImageUploader('imagesSale', 'imagePreviewSale');
setupImageUploader('decorImages', 'decorImagePreview');
setupImageUploader('materialImages', 'materialImagePreview');





  // Profile tab switch
  document.querySelectorAll('.profile-tab-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      // Remove 'active' from all buttons and tab contents
      document.querySelectorAll('.profile-tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.profile-tab-content').forEach(tab => tab.classList.remove('active'));

      // Add 'active' to clicked button and corresponding tab
      this.classList.add('active');
      const target = this.getAttribute('data-profile-tab');
      document.getElementById('profile-' + target).classList.add('active');
    });
  });

function toggleAdvanced() {
  const advanced = document.getElementById("advancedFilters");
  advanced.classList.toggle("hidden");
}



/*  view for active*/
    document.getElementById('categoryFilter').addEventListener('change', function () {
      const selected = this.value;
      const cards = document.querySelectorAll('.property-card');

      cards.forEach(card => {
        const category = card.getAttribute('data-category');
        if (selected === 'all' || category === selected) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });

/* end of view  */



  document.addEventListener("DOMContentLoaded", function () {
    const submenuButtons = document.querySelectorAll(".submenu-btn");
    const viewSections = document.querySelectorAll("#view > div"); // All children under #view

    submenuButtons.forEach((btn) => {
      btn.addEventListener("click", function () {
        const formId = btn.getAttribute("data-form");

        // Hide all sections under #view
        viewSections.forEach((section) => {
          section.style.display = "none";
        });

        // Show the selected one
        const selectedSection = document.getElementById(formId);
        if (selectedSection) {
          selectedSection.style.display = "block";
        }
      });
    });

    // Filtering for pending approval section
    const filterSelect = document.getElementById("pendingCategoryFilter");
    if (filterSelect) {
      filterSelect.addEventListener("change", function () {
        const selected = this.value.toLowerCase();
        const cards = document.querySelectorAll(".pending-wrapper .property-card");

        cards.forEach((card) => {
          const category = card.dataset.category?.toLowerCase() || "";
          card.style.display = selected === "" || category.includes(selected) ? "flex" : "none";
        });
      });
    }
  });






   

</script>

</body>
</html>
