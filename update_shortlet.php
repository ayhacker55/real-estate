<?php
$db = @mysqli_connect("localhost", "root", "", "real_estate") or die("Could not connect");

function clean($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $propertyId = intval($_POST['id'] ?? 0);
    if ($propertyId <= 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid property ID.'
        ]);
        exit;
    }

    // Get existing gallery JSON from DB
    $result = mysqli_query($db, "SELECT gallery FROM property WHERE id = $propertyId");
    if (!$result || mysqli_num_rows($result) === 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Property not found.'
        ]);
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    $existingGallery = json_decode($row['gallery'], true) ?: [];

    // Delete images marked for removal
    if (!empty($_POST['removeImages'])) {
        foreach ($_POST['removeImages'] as $removeId) {
            if (preg_match('/existing-(\d+)/', $removeId, $matches)) {
                $idx = intval($matches[1]);
                if (isset($existingGallery[$idx])) {
                    $fileToDelete = __DIR__ . '/' . $existingGallery[$idx];
                    if (file_exists($fileToDelete)) {
                        unlink($fileToDelete);
                    }
                    unset($existingGallery[$idx]);
                }
            }
        }
        $existingGallery = array_values($existingGallery); // Re-index array after removal
    }

    // Handle new uploads
    if (!empty($_FILES['galleryPhotos'])) {
        $files = $_FILES['galleryPhotos'];
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $total = count($files['name']);
        for ($i = 0; $i < $total; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $tmpName = $files['tmp_name'][$i];
                $name = basename($files['name'][$i]);
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                    $newName = uniqid('img_', true) . '.' . $ext;
                    $target = $uploadDir . $newName;
                    if (move_uploaded_file($tmpName, $target)) {
                        $existingGallery[] = 'uploads/' . $newName;
                    }
                }
            }
        }
    }

    $galleryJson = json_encode($existingGallery);

    // Clean and fetch other POST data
    $features = isset($_POST['features']) ? $_POST['features'] : [];
    $featuresJson = json_encode($features);

    $title = clean($_POST['title'] ?? '');
    $type = clean($_POST['type'] ?? '');
    $listing_type = clean($_POST['listingType'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $status = clean($_POST['status'] ?? '');
    $country = clean($_POST['country'] ?? '');
    $state = clean($_POST['state'] ?? '');
    $city = clean($_POST['lga'] ?? '');
    $street = clean($_POST['addres'] ?? '');

    $bedrooms = intval($_POST['bedrooms'] ?? 0);
    $bathrooms = intval($_POST['bathrooms'] ?? 0);
    $toilets = intval($_POST['toilets'] ?? 0);
    $living_rooms = intval($_POST['livingRooms'] ?? 0);
    $kitchens = intval($_POST['kitchens'] ?? 0);

    $smoke = clean($_POST['smoke'] ?? '');
 
    $description = clean($_POST['description'] ?? '');


    $query = "
        UPDATE property SET
            title = '" . mysqli_real_escape_string($db, $title) . "',
            type = '" . mysqli_real_escape_string($db, $type) . "',
            listing_type = '" . mysqli_real_escape_string($db, $listing_type) . "',
            price = $price,
            status = '" . mysqli_real_escape_string($db, $status) . "',
            country = '" . mysqli_real_escape_string($db, $country) . "',
            state = '" . mysqli_real_escape_string($db, $state) . "',
            city = '" . mysqli_real_escape_string($db, $city) . "',
            street = '" . mysqli_real_escape_string($db, $street) . "',
            bedrooms = $bedrooms,
            bathrooms = $bathrooms,
            toilets = $toilets,
            living_rooms = $living_rooms,
            kitchens = $kitchens,
            smoke = '" . mysqli_real_escape_string($db, $smoke) . "',
        
            description = '" . mysqli_real_escape_string($db, $description) . "',
          
            features = '" . mysqli_real_escape_string($db, $featuresJson) . "',
            gallery = '" . mysqli_real_escape_string($db, $galleryJson) . "'
        WHERE id = $propertyId
    ";

    if (mysqli_query($db, $query)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Property updated successfully.',
            'redirect' => "edit_shortlet.php?id=$propertyId"
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error updating property: ' . mysqli_error($db)
        ]);
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
