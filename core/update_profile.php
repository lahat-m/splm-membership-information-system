<?php
session_start();

include '../config/db_connect.php';

// Initialize $user_type and $user_id
$user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

if ($user_type == '' || $user_id == '') {
    echo "Invalid user type or user ID.";
    exit;
}

// Prepare and execute SQL query to update user details based on user type
$table_name = ($user_type === 'Applicant') ? 'applicants' : 'admins';

$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$national_id = $_POST['national_id'];

if ($user_type === 'Applicant') {
    $sql = "UPDATE $table_name SET first_name = ?, middle_name = ?, surname = ?, email = ?, phone = ?, national_id = ? WHERE id_applicant = ?";
} else {
    $sql = "UPDATE $table_name SET first_name = ?, middle_name = ?, surname = ?, email = ?, phone = ?, national_id = ? WHERE id_admin = ?";
}

$stmt = $conn->prepare($sql);

// Check if prepare() was successful
if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->bind_param("ssssssi", $first_name, $middle_name, $surname, $email, $phone, $national_id, $user_id);

if ($stmt->execute() === false) {
    die("Error executing the statement: " . $stmt->error);
} else {
    echo "Profile updated successfully.";
    header('Location: ../views/admin_dashboard.php');

}

$stmt->close();
$conn->close();