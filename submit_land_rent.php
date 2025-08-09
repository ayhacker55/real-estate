<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db.php'; // Make sure this file sets up $conn properly

    // Sanitize input
    $title = htmlspecialchars($_POST['title']);
    $propertyType = htmlspecialchars($_POST['propertyType']);
    $description = htmlspecialchars($_POST['description']);
    $state = htmlspecialchars($_POST['state']);
    $lga = htmlspecialchars($_POST['lga']);
    $address = htmlspecialchars($_POST['address']);
    $size = (int) $_POST['size'];
    $rentPrice = (float) $_POST['rentPrice'];
    $category = htmlspecialchars($_POST['category']);
    $duration = htmlspecialchars($_POST['duration']);
    $facilities = htmlspecialchars($_POST['facilities']);

    // Image upload handling
    $uploadDir = 'uploads/';
    $uploadedPaths = [];

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($_FILES['images1']['name'][0])) {
        foreach ($_FILES['images1']['tmp_name'] as $key => $tmpName) {
            $originalName = basename($_FILES['images1']['name'][$key]);
            $uniqueName = uniqid('img_') . '_' . $originalName;
            $targetPath = $uploadDir . $uniqueName;
            if (move_uploaded_file($tmpName, $targetPath)) {
                $uploadedPaths[] = $targetPath;
            }
        }
    }

    $imageList = json_encode($uploadedPaths);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO land_rent (title, property_type, description, state, lga, address, size, rent_price, category, duration, facilities, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssdssss", $title, $propertyType, $description, $state, $lga, $address, $size, $rentPrice, $category, $duration, $facilities, $imageList);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "✅ Land for rent added successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "❌ Failed to save record: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
