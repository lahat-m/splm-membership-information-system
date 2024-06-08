<?php
session_start();
include '../config/db_connect.php';

// Assuming the applicant's ID is stored in the session
$user_type = $_SESSION['user_type'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
$email = $_SESSION['email'] ?? null;
$username = $_SESSION['username'] ?? null;

if (!$user_type || !$user_id) {
    echo "No applicant ID found.";
    exit();
}

// Fetch application details
$query = "SELECT * FROM applications WHERE id_application = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo "Failed to prepare statement: " . $conn->error;
    exit();
}

$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$id_application = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
