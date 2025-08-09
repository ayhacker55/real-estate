<?php
session_start();
$username = $_SESSION['user'] ?? null;
$db = @mysqli_connect("localhost", "root", "", "real_estate") or die("could not connect");

function clean($data) {
    return htmlspecialchars(trim($data));
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Clean and fetch POST data
    $title = clean($_POST['title'] ?? '');
    $type = clean($_POST['type'] ?? '');
    $listingType = clean($_POST['listingType'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $status = clean($_POST['status'] ?? '');
    $country = "Nigeria"; // hardcoded because your form has only "state", not "country"
    $state = clean($_POST['state'] ?? '');
    $city = clean($_POST['lga'] ?? '');
    $street = clean($_POST['address'] ?? '');
    $bedrooms = intval($_POST['bedrooms'] ?? 0);
    $bathrooms = intval($_POST['bathrooms'] ?? 0);
    $toilets = intval($_POST['toilets'] ?? 0);
    $livingRooms = intval($_POST['livingRooms'] ?? 0);
    $kitchens = intval($_POST['kitchens'] ?? 0);
    $propertySize = clean($_POST['propertySize'] ?? '');
 $condition = clean($_POST['condition'] ?? '');
  $funish = clean($_POST['furnished'] ?? '');

    $description = clean($_POST['description'] ?? '');
 
    $features = $_POST['features'] ?? [];

    // Handle multiple photo uploads
    $uploadedFiles = [];
    if (!empty($_FILES['galleryPhotos'])) {
        $files = $_FILES['galleryPhotos'];
        $total = count($files['name']);
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        for ($i = 0; $i < $total; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $tmpName = $files['tmp_name'][$i];
                $name = basename($files['name'][$i]);
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $newName = uniqid('prop_', true) . '.' . $ext;
                    $target = $uploadDir . $newName;
                    if (move_uploaded_file($tmpName, $target)) {
                        $uploadedFiles[] = 'uploads/' . $newName;
                    }
                }
            }
        }
    }

    // JSON encode gallery and features
    $galleryJson = mysqli_real_escape_string($db, json_encode($uploadedFiles));
    $featuresJson = mysqli_real_escape_string($db, json_encode($features));

    $query = "INSERT INTO property
    (username,user_type,title, type, listing_type, price, status, `condition`, funish, country, state, city, street,
    bedrooms, bathrooms, toilets, living_rooms, kitchens, property_size, 
    description, created_at, gallery, features, views, publish)
    VALUES  
    (
        '" . mysqli_real_escape_string($db, $username ) . "',
         'seller',
         '" . mysqli_real_escape_string($db, $title) . "',
        '" . mysqli_real_escape_string($db, $type) . "',
        '" . mysqli_real_escape_string($db, $listingType) . "',
        $price,
        '" . mysqli_real_escape_string($db, $status) . "',
        '" . mysqli_real_escape_string($db, $condition) . "',
        '" . mysqli_real_escape_string($db, $funish) . "',
        '" . mysqli_real_escape_string($db, $country) . "',
        '" . mysqli_real_escape_string($db, $state) . "',
        '" . mysqli_real_escape_string($db, $city) . "',
        '" . mysqli_real_escape_string($db, $street) . "',
        $bedrooms,
        $bathrooms,
        $toilets,
        $livingRooms,
        $kitchens,
        '" . mysqli_real_escape_string($db, $propertySize) . "',
        '" . mysqli_real_escape_string($db, $description) . "',
        NOW(),
        '$galleryJson',
        '$featuresJson',
        0,
        'pending'
    )";


    if (mysqli_query($db, $query)) {
        echo "Success: Property listing uploaded.";
    } else {
        echo "Error inserting property: " . mysqli_error($db);
    }

    mysqli_close($db);
} else {
    echo "Invalid request method.";
}
?>
