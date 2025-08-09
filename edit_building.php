<?php
session_start();

// If user is not logged in, redirect to login
if (!isset($_SESSION['user'])) {
  header("Location: index.html");
  exit;
}
$username=$_SESSION['user'];
?>
<?php
include('header.php');
$db = @mysqli_connect("localhost", "root", "", "real_estate") or die("Could not connect");

// Fetch categories for dropdown (same as before)
$query = "SELECT id, cate FROM category ORDER BY 1";
$result = mysqli_query($db, $query);

// Get property ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('Invalid property ID');
}

// Fetch property data
$sql = "SELECT `id`, `username`, `title`, `type`, `listing_type`, `price`, `status`, `country`, `state`, `city`, `street`, `bedrooms`, `bathrooms`, `toilets`, `living_rooms`, `kitchens`, `smoke`, `property_size`, `land_size`, `duration`, `condition`, `furnished`, `description`, `facility`, `gallery`, `features`, `views`, `publish`, `created_at` FROM `property` WHERE id = $id  LIMIT 1";
$res = mysqli_query($db, $sql);
if (mysqli_num_rows($res) == 0) {
    die('Property not found');
}
$property = mysqli_fetch_assoc($res);

// Decode features (assuming stored as JSON array)
$features = json_decode($property['features'], true) ?: [];

?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
<style>
#galleryPreview .col {
  position: relative;
}

#galleryPreview img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
  transition: transform 0.2s;
}

#galleryPreview img:hover {
  transform: scale(1.02);
}

</style>


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
  

<section class="w3-content w3-white w3-padding w3-card">
  <h2>Edit Building Material</h2>
  <form id="propertyForm" method="POST" enctype="multipart/form-data" action="update_decor.php">
 <input type="hidden" name="id" value="<?= htmlspecialchars($property['id']) ?>" />



    <!-- Basic Details -->
    <div class="mb-4">
  
      <div class="row g-3">
        <div class="col-md-6">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" placeholder="e.g., Modern 4-Bedroom Duplex" required
            value="<?= htmlspecialchars($property['title']) ?>" />
        </div>
  
        <div class="col-md-3">
          <label for="listingType" class="form-label">Condition</label>
          <select class="form-select form-control" id="listingType" name="listingType" required>
            <option <?= ($property['listing_type'] == 'imported') ? 'selected' : '' ?>>Foreign</option>
            <option <?= ($property['listing_type'] == 'used') ? 'selected' : '' ?>>Used</option>
            <option <?= ($property['listing_type'] == 'new') ? 'selected' : '' ?>>Newly Manufactured</option>


          </select>
        </div>
        <div class="col-md-3">
          <label for="price" class="form-label">Price</label>
          <input type="number" class="form-control" id="price" name="price" required value="<?= htmlspecialchars($property['price']) ?>" />
        </div>
       
      </div>
    </div>

    <!-- Location Details -->
    <div class="mb-4">
      <h4>Location Details</h4>
      <div class="row g-3">
       
        <div class="col-md-4">
          <label class="form-label">State/Province</label>
           <select class="form-select form-control" name="state" required>
    <option selected disabled>State</option>
    <option value="<?= htmlspecialchars($property['state']) ;?>" selected> <?= htmlspecialchars($property['state']) ?></option>
    
 
  </select>
        </div>
   <div class="col-md-4">
  <label class="form-label">LGA</label>
  <select class="form-select form-control" name="lga" required>
    <option >Select LGA</option>
    <option value="<?= htmlspecialchars($property['city']) ?>" selected><?= htmlspecialchars($property['city']) ?></option>
     <option >Amac</option>
  </select>
</div>


        <div class="col-md-4">
          <label class="form-label">Address</label>
          <input type="text" class="form-control" name="addres" value="<?= htmlspecialchars($property['street']) ?>" />
        </div>
        
      </div>
    </div>


  




 <!-- Gallery Photos -->
<div class="w3-margin-bottom">
  <h4>Gallery Photos</h4>

  <!-- Dynamic upload input area -->
  <div id="photoInputs" class="w3-container w3-padding-small w3-border w3-round w3-light-grey w3-margin-bottom"></div>
  <button type="button" class="w3-button w3-blue w3-small w3-margin-top" onclick="addPhotoInput()">➕ Add Photo</button>

  <!-- Gallery preview -->
  <div id="galleryPreview" class="w3-row-padding w3-margin-top">

    <?php
      $galleryImages = json_decode($property['gallery'], true) ?: [];
      foreach ($galleryImages as $index => $imgPath):
    ?>
    <div class="w3-third w3-container w3-margin-bottom" data-id="<?= $imgId ?>">

        <div class="w3-display-container w3-hover-shadow">
          <img src="<?= htmlspecialchars($imgPath) ?>" class="w3-image" style="height: 200px; object-fit: cover; border-radius: 6px;">
          <button
            type="button"
            class="w3-button w3-red w3-tiny w3-display-topright"
            onclick="removeExistingImage(this, 'existing-<?= $index ?>')"
            style="padding: 2px 8px;"
          >
            &times;
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

    <!-- Description -->
    <div class="mb-4">
      <h4>Description</h4>
      <textarea class="form-control" name="description" rows="5" placeholder="Describe the property, neighborhood, features, etc." required><?= htmlspecialchars($property['description']) ?></textarea>
    </div>



   <!-- Contact Info -->
    <div class="mb-4">
    <!-- Submit Button -->
    <hr>
    <center><button type="submit" class="btn btn-primary">Submit</button></center>
    </div>

  </form>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  let photoId = 0;
  const galleryPreview = document.getElementById('galleryPreview');
  const photoInputs = document.getElementById('photoInputs');

  // Store IDs of images marked for deletion
  const imagesToRemove = new Set();

  function addPhotoInput() {
    const id = 'photo-' + photoId++;

    const inputGroup = document.createElement('div');
    inputGroup.classList.add('d-flex', 'align-items-center', 'gap-2');
    inputGroup.setAttribute('data-id', id);

    const input = document.createElement('input');
    input.type = 'file';
    input.name = 'galleryPhotos[]';
    input.accept = 'image/*';
    input.classList.add('form-control');

    input.onchange = function (e) {
      const file = e.target.files[0];
      if (file) {
        const existing = galleryPreview.querySelector(`[data-id="${id}"]`);
        if (existing) existing.remove();

        const imgWrapper = document.createElement('div');
        imgWrapper.classList.add('w3-third', 'w3-container', 'w3-margin-bottom');
        imgWrapper.setAttribute('data-id', id);

        const imgBox = document.createElement('div');
        imgBox.classList.add('w3-display-container', 'w3-hover-shadow');

        const img = document.createElement('img');
        img.classList.add('w3-image');
        img.style.height = '200px';
        img.style.objectFit = 'cover';
        img.style.borderRadius = '6px';

        const delBtn = document.createElement('button');
        delBtn.type = 'button';
        delBtn.innerHTML = '&times;';
        delBtn.classList.add('w3-button', 'w3-red', 'w3-tiny', 'w3-display-topright');
        delBtn.style.padding = '2px 8px';
        delBtn.onclick = () => {
          inputGroup.remove();
          imgWrapper.remove();
        };

        const reader = new FileReader();
        reader.onload = function (e) {
          img.src = e.target.result;
        };
        reader.readAsDataURL(file);

        imgBox.appendChild(img);
        imgBox.appendChild(delBtn);
        imgWrapper.appendChild(imgBox);
        galleryPreview.appendChild(imgWrapper);
      }
    };

    inputGroup.appendChild(input);
    photoInputs.appendChild(inputGroup);
  }

  // Remove existing image, mark for deletion
  function removeExistingImage(button, id) {
    const wrapper = button.parentElement;
    wrapper.remove();
    imagesToRemove.add(id);
  }

  // Before form submit, append hidden inputs with IDs of removed images
  $('#propertyForm').on('submit', function (e) {
    imagesToRemove.forEach(id => {
      $('<input>').attr({
        type: 'hidden',
        name: 'removeImages[]',
        value: id
      }).appendTo(this);
    });
  });

  // AJAX form submit with JSON response handling and redirect
  $(document).ready(function () {
    $('#propertyForm').on('submit', function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      $.ajax({
        url: 'update_building.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          try {
            const data = JSON.parse(response);
            if (data.status === 'success') {
              alert(data.message);
              window.location.href = data.redirect;
            } else {
              alert('Error: ' + data.message);
            }
          } catch (e) {
            alert('Unexpected response from server.');
          }
        },
        error: function (xhr, status, error) {
          alert('Something went wrong: ' + error);
        }
      });
    });

    // On load, add one photo input
    addPhotoInput();

    // Render existing images from hidden input JSON
    const existingGallery = JSON.parse(document.getElementById('existingGallery').value || '[]');
    renderExistingImages(existingGallery);
  });

  // Render existing images with delete buttons bound to removeExistingImage
  function renderExistingImages(images) {
    images.forEach((src, index) => {
      const imgWrapper = document.createElement('div');
      imgWrapper.classList.add('w3-third', 'w3-container', 'w3-margin-bottom');
      imgWrapper.setAttribute('data-id', `existing-${index}`);

      const imgBox = document.createElement('div');
      imgBox.classList.add('w3-display-container', 'w3-hover-shadow');

      const img = document.createElement('img');
      img.classList.add('w3-image');
      img.style.height = '200px';
      img.style.objectFit = 'cover';
      img.style.borderRadius = '6px';
      img.src = src;

      const delBtn = document.createElement('button');
      delBtn.type = 'button';
      delBtn.innerHTML = '&times;';
      delBtn.classList.add('w3-button', 'w3-red', 'w3-tiny', 'w3-display-topright');
      delBtn.style.padding = '2px 8px';
      delBtn.onclick = function () {
        removeExistingImage(this, `existing-${index}`);
      };

      imgBox.appendChild(img);
      imgBox.appendChild(delBtn);
      imgWrapper.appendChild(imgBox);
      galleryPreview.appendChild(imgWrapper);
    });
  }
</script>


<script src="allform.js"></script>
<script src="image.js"></script>
<script src="main.js"></script>

<script src="seller.js?v=2"></script>


</section>
</main>
</div>
</div>



  
  </body>
</html>