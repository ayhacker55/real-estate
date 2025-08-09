<?php
header('Content-Type: application/json');

$uploadDir = 'uploads/';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'No file or upload error']);
    exit;
}

$file = $_FILES['photo'];
$name = basename($file['name']);
$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

if (!in_array($ext, $allowed)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid file type']);
    exit;
}

$newName = uniqid('img_') . '.' . $ext;
$fullPath = $uploadDir . $newName;

if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
    exit;
}

echo json_encode(['status' => 'success', 'path' => $fullPath]);
?>