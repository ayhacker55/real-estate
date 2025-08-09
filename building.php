<?php
session_start();

// If user is not logged in, redirect to login
if (!isset($_SESSION['user'])) {
  header("Location: index.html");
  exit;
}

$username = $_SESSION['user'] ?? '';

?>
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">

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



 <main class="main">
  
       <section class="content">
   

 <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">


<?php
$db = @mysqli_connect("localhost", "root", "", "real_estate") or die("Could not connect");

// Fetch paginated categories
$query = "SELECT id, cate FROM category ORDER BY 1";
$result = mysqli_query($db, $query);
?>
        <!-- Main content -->
        <section class="w3-content w3-white w3-padding w3-card">
         
             
 <h2 class="mb-4">Building Material</h2>
  <form id="propertyForm" method="POST" enctype="multipart/form-data">

    <!-- Basic Details -->
    <div class="mb-4">
   
      <div class="row g-3">
        <div class="col-md-6">
          <label for="title" class="form-label">Name</label>
          <input type="text" class="form-control " id="title" name="title" required />
        </div>

        <div class="col-md-3">
          <label for="listingType" class="form-label">Condition:</label>
          <select class="form-select form-control " id="listingType" name="listingType" required>
       <option value="">Select type</option>
 
      <option value="imported">Foreign</option>
      <option value="used">Used</option>
      <option value="new">Newly Manufactured</option>
          </select>
        </div>
        <div class="col-md-3">
          <label for="price" class="form-label">Price</label>
          <input type="number" class="form-control " id="price" name="price" required />
        </div>
 
      </div>
    </div>

    <!-- Location -->
    <div class="mb-4">
      <h4>Location Details</h4>
      <div class="row g-3">
      <div class="col-md-4">
  <label class="form-label">State/Province</label>
  <select class="form-select form-control" name="state" required>
    <option selected disabled>Select State</option>
    <option value="Abia">Abia</option>
    <option value="Adamawa">Adamawa</option>
    <option value="Akwa Ibom">Akwa Ibom</option>
    <option value="Anambra">Anambra</option>
    <option value="Bauchi">Bauchi</option>
  
  </select>
</div>
  <div class="col-md-4">
            <label class="form-label">LGA</label>
  <select class="form-select form-control" name="lga" required>
    <option selected disabled>Select LGA</option>
  <option value="MAC">MAC</option>
<option value="KUJE">KUJE</option>

 
  </select>
        </div>

  <div class="col-md-4">
          <label class="form-label">Address</label>
          <input type="text" class="form-control " name="address" required />

        </div>

        
      </div>
    </div>


    <div class="mb-4">
        <div class="row">



</div>
</div>


    <!-- Gallery Photos -->
    <div class="mb-4">
      <h4>Gallery Photos</h4>
      <div id="photoInputs" class="d-flex flex-column gap-3"></div>
      <button type="button" class="btn btn-outline-primary mt-2" onclick="addPhotoInput()">➕ Add Photo</button>
    </div>
<span id="galleryPreview" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"></span>





    <!-- Description -->
    <div class="mb-4">
      <h4>Description</h4>
      <textarea class="form-control " name="description" rows="5" placeholder="Describe the property" required></textarea>
    </div>

    <!-- Contact Info -->
    <div class="mb-4">
    <!-- Submit Button -->
    <hr>
    <center><button type="submit" class="btn btn-primary">Submit</button></center>
    </div>


    <hr>
  </form> 
</div>
   </section>
  </main>
 



   
  

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  let photoId = 0;

 function addPhotoInput() {
  const inputContainer = document.getElementById('photoInputs');
  const previewContainer = document.getElementById('galleryPreview');
  const id = 'photo-' + photoId++;

  const inputGroup = document.createElement('div');
  inputGroup.classList.add('d-flex', 'align-items-center', 'gap-2');
  inputGroup.setAttribute('data-id', id);

  const input = document.createElement('input');
  input.type = 'file';
  input.name = 'galleryPhotos[]';
  input.accept = 'image/*';
  input.classList.add('form-control');
  input.required = true;

  input.onchange = function (e) {
    const file = e.target.files[0];
    if (file) {
      // Remove any previous preview for this input
      const existing = previewContainer.querySelector(`[data-id="${id}"]`);
      if (existing) existing.remove();

      // W3.CSS style preview
      const imgWrapper = document.createElement('div');
      imgWrapper.className = 'w3-third w3-container w3-margin-bottom';
      imgWrapper.setAttribute('data-id', id);

      const imgContainer = document.createElement('div');
      imgContainer.className = 'w3-display-container w3-hover-shadow';

      const img = document.createElement('img');
      img.src = URL.createObjectURL(file);
      img.className = 'w3-image';
    
img.style.width = '100%';          // ✅ Full width
img.style.height = '200px';        // ✅ Fixed height
img.style.objectFit = 'cover';     // ✅ Keeps image aspect ratio clean
img.style.borderRadius = '6px';    // ✅ Rounded corners

      const delBtn = document.createElement('button');
      delBtn.type = 'button';
      delBtn.className = 'w3-button w3-red w3-tiny w3-display-topright';
      delBtn.style.padding = '2px 8px';
      delBtn.innerHTML = '&times;';
      delBtn.onclick = () => {
        inputGroup.remove();
        imgWrapper.remove();
      };

      imgContainer.appendChild(img);
      imgContainer.appendChild(delBtn);
      imgWrapper.appendChild(imgContainer);
      previewContainer.appendChild(imgWrapper);
    }
  };

  inputGroup.appendChild(input);
  inputContainer.appendChild(inputGroup);
}


  // Add one photo input on load
  window.onload = addPhotoInput;

  // AJAX form submit
  $(document).ready(function () {
    $('#propertyForm').on('submit', function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      $.ajax({
        url: 'upload_building.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if (response.toLowerCase().includes('success')) {
            alert(response);
            $('#propertyForm')[0].reset();
            $('#galleryPreview').empty();
            $('#photoInputs').empty();
            addPhotoInput();
          } else {
            alert('Error: ' + response);
          }
        },
        error: function (xhr, status, error) {
          alert('Something went wrong: ' + error);
        }
      });
    });
  });
</script>
   

    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const typeSelect = document.getElementById("type");

    const featureIDs = ["parking", "pool", "internet", "ac"];
    const specNames = ["bedrooms", "bathrooms", "toilets", "livingRooms", "kitchens"];

    function toggleFields() {
      const selectedType = typeSelect.value?.toLowerCase() || "";
      const isLand = selectedType.includes("land");

      // Toggle Features
      featureIDs.forEach(id => {
        const feature = document.getElementById(id);
        const wrapper = feature?.closest(".col-md-3");
        if (wrapper) {
          wrapper.style.display = isLand ? "none" : "block";
          feature.required = !isLand;
        }
      });

      // Toggle Specifications
      specNames.forEach(name => {
        const input = document.querySelector(`[name="${name}"]`);
        const wrapper = input?.closest(".col-md-2");
        if (wrapper) {
          wrapper.style.display = isLand ? "none" : "block";
          input.required = !isLand;
        }
      });
    }

    // Initial run in case the form is reloaded with a selected value
    toggleFields();

    // Run on change of the property type dropdown
    typeSelect.addEventListener("change", toggleFields);
  });
</script>

<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>    
<script src="seller.js?v=2"></script>
<script src="allform.js"></script>
<script src="image.js"></script>
<script src="main.js"></script>


</body>
</html>
