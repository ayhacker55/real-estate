<?php
session_start();

// If user is not logged in, redirect to login
if (!isset($_SESSION['user'])) {
  header("Location: index.html");
  exit;
}

// Optional: get user plan from sessions
$plan = $_SESSION['plan'] ?? '';
$username = $_SESSION['user'] ?? '';
include('header.php');
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
         
             
 <h2 class="mb-4">Landed Property</h2>
  <form id="propertyForm" method="POST" enctype="multipart/form-data">

    <!-- Basic Details -->
    <div class="mb-4">
   
      <div class="row g-3">
        <div class="col-md-6">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control " id="title" name="title" required />
        </div>

        <div class="col-md-3">
          <label for="listingType" class="form-label">Listing Type</label>
          <select class="form-select form-control " id="listingType" name="listingType" required>
            <option>For Sale</option>
            <option>For Rent</option>
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
    <option value="Abia">MAC</option>
    <option value="Adamawa">KUJE</option>
 
  </select>
        </div>

  <div class="col-md-4">
          <label class="form-label">Location</label>
          <input type="text" class="form-control " name="addres" required />
        </div>

        
      </div>
    </div>


    <div class="mb-4">
        <div class="row">


  <div class="col-md-4">
  <label class="form-label">Land Size (sqm)</label>
          <input type="text" class="form-control " name="landsize" />
        </div>

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
      <h4>Facilities</h4>
      <textarea class="form-control " name="facility" rows="5" placeholder="Available Facilities" required></textarea>
    </div>


    <!-- Description -->
    <div class="mb-4">
      <h4>Land Description</h4>
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
        url: 'upload_land.php',
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
