<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "real_estate") or die("Could not connect");

$username = $_SESSION['user'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $username) {
    $current_password = $_POST['current_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Check current password
    $query = "SELECT `password` FROM `users` WHERE `username` = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($current_password, $hashed_password)) {
        // Update password
        $update = $db->prepare("UPDATE `users` SET `password` = ? WHERE `username` = ?");
        $update->bind_param("ss", $new_password, $username);
        $update->execute();

        // ✅ Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>alert('Current password is incorrect.')</script>";
         header("Location: dashboard.php");
    }
} else {
    echo "Unauthorized access.";
}
?>
