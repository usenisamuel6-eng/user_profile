<?php 
session_start();
require_once "../config/db_connection.php";

$user_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $profile_image = $user["profile_image"];

    if (!empty($profile_image)) {
        $file_path = "uploads/profiles/" . $profile_image;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
}

$stmt1 = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt1->bind_param("i", $user_id);
$stmt1->execute();

session_destroy();
header("Location: ../index.php?msg=" . "Profile deleted successfully");
exit();
?>