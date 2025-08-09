<?php
session_start();

// If user is not logged in, redirect to login
$username=$_SESSION['user'];
$db = @mysqli_connect("localhost", "root", "", "real_estate") or die("Could not connect to DB");

function clean($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $title = clean($_POST['title'] ?? '');
    $listingType = clean($_POST['listingType'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $state = clean($_POST['state'] ?? '');
    $city = clean($_POST['lga'] ?? '');
    $street = clean($_POST['addres'] ?? '');
    $country = "Nigeria";

  

    // Description
    $description = clean($_POST['description'] ?? '');

    // Contact
   // $contactName = clean($_POST['contactName'] ?? '');
    //$phone = clean($_POST['phone'] ?? '');
    //$email = clean($_POST['email'] ?? '');

    // Features (checkbox array)
    $features = $_POST['features'] ?? [];
    $featuresJson = mysqli_real_escape_string($db, json_encode($features));

    // Handle image uploads
    $uploadedFiles = [];
    if (!empty($_FILES['galleryPhotos'])) {
        $files = $_FILES['galleryPhotos'];
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $tmpName = $files['tmp_name'][$i];
                $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
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

    $galleryJson = mysqli_real_escape_string($db, json_encode($uploadedFiles));

$query = "INSERT INTO property (
    username, title, type, listing_type, price, status,
    country, state, city, street,  description, 
    created_at, gallery, features, views, publish
) VALUES (
    '$username', '$title', 'Decor', '$listingType', $price, 'Available',
    '$country', '$state', '$city', '$street',
     '$description', 
    NOW(), '$galleryJson', '$featuresJson', 0, 'pending'
)";



    if (mysqli_query($db, $query)) {
        echo "Success: Decor uploaded.";
    } else {
        echo "Error: " . mysqli_error($db);
    }

    mysqli_close($db);
} else {
    echo "Invalid request method.";
}
