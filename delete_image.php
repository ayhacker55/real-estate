<?php
header('Content-Type: application/json');
$db = @mysqli_connect("localhost", "root", "", "real_estate");
if (!$db) {
    echo json_encode(['status' => 'error', 'message' => 'DB connection failed']);
    exit;
}

function clean($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES);
}

// Make sure request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

// Get property ID
$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid property ID']);
    exit;
}

// Prepare updates (you can add more fields if needed)
$title = clean($_POST['title'] ?? '');
$description = clean($_POST['description'] ?? '');
$price = floatval($_POST['price'] ?? 0);

// Update property details
$updateQuery = "UPDATE property SET title='$title', description='$description', price='$price' WHERE id=$id";
if (!mysqli_query($db, $updateQuery)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update property info']);
    exit;
}

// --- Handle gallery images ---

$uploadDir = 'uploads/';
$newImages = [];

// Upload newly selected gallery photos
if (!empty($_FILES['galleryPhotos']['name'][0])) {
    foreach ($_FILES['galleryPhotos']['tmp_name'] as $index => $tmpName) {
        $fileName = basename($_FILES['galleryPhotos']['name'][$index]);
        $targetPath = $uploadDir . time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName);
        
        if (move_uploaded_file($tmpName, $targetPath)) {
            $newImages[] = $targetPath;
        }
    }
}

// Get existing gallery images (from form)
$existingGallery = [];
if (!empty($_POST['existingGallery'])) {
    $decoded = json_decode($_POST['existingGallery'], true);
    if (is_array($decoded)) {
        $existingGallery = array_filter($decoded);
    }
}

// Merge and save updated gallery
$finalGallery = array_merge($existingGallery, $newImages);
$galleryJson = json_encode(array_values($finalGallery));

$saveGalleryQuery = "UPDATE property SET gallery = '$galleryJson' WHERE id = $id";
if (!mysqli_query($db, $saveGalleryQuery)) {
    echo json_encode(['status' => 'error', 'message' => 'Property updated but gallery update failed']);
    exit;
}

echo json_encode(['status' => 'success', 'message' => 'Property updated successfully']);
?>
