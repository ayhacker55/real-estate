<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    echo "Unauthorized. Please log in.";
    exit;
}

$username = $_SESSION['user'];

// Connect to database
$db = mysqli_connect("localhost", "root", "", "real_estate");
if (!$db) {
    echo "Database connection failed: " . mysqli_connect_error();
    exit;
}

// Sanitize input
function clean($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title        = clean($_POST['title'] ?? '');
    $condition    = clean($_POST['listingType'] ?? '');
    $price        = floatval($_POST['price'] ?? 0);
    $state        = clean($_POST['state'] ?? '');
    $lga          = clean($_POST['lga'] ?? '');
    $address      = clean($_POST['address'] ?? '');
    $description  = clean($_POST['description'] ?? '');
    $country      = "Nigeria";
    $uploadDir    = __DIR__ . '/uploads/';
    $imagePaths   = [];

    // Create upload directory if not exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle images
    if (!empty($_FILES['galleryPhotos']['name'][0])) {
        foreach ($_FILES['galleryPhotos']['tmp_name'] as $index => $tmpName) {
            $originalName = basename($_FILES['galleryPhotos']['name'][$index]);
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($ext, $allowed)) {
                $newName = uniqid('img_', true) . '.' . $ext;
                $targetPath = $uploadDir . $newName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $imagePaths[] = 'uploads/' . $newName;
                }
            }
        }
    } else {
        echo "Please upload at least one image.";
        exit;
    }

    // Encode images as JSON for DB
    $imageJson = json_encode($imagePaths);

    // Prepare SQL
    $sql = "INSERT INTO property (
                username, title, `condition`, price, state, lga, address, country, description,     gallery, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = mysqli_prepare($db, $sql);
    if (!$stmt) {
        echo "Failed to prepare statement: " . mysqli_error($db);
        exit;
    }

    // Bind parameters - match placeholders (10 ?)
    mysqli_stmt_bind_param(
        $stmt,
        "sssdssssss",
        $username,
        $title,
        $condition,
        $price,
        $state,
        $lga,
        $address,
        $country,
        $description,
        $imageJson
    );

    // Execute
    if (mysqli_stmt_execute($stmt)) {
        echo "✅ Success: Property listed successfully!";
    } else {
        echo "❌ Error saving to database: " . mysqli_stmt_error($stmt);
    }

    // Cleanup
    mysqli_stmt_close($stmt);
    mysqli_close($db);

} else {
    echo "Invalid request.";
}
?>
z