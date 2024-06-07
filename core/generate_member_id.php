<?php
session_start();
include '../config/db_connect.php';

if (isset($_GET['application_id'])) {
    $application_id = $_GET['application_id'];

    // Fetch application details
    $query = "SELECT first_name, middle_name, surname, gender, dob, national_id, residential_city, statename, county, payam, boma, date_of_join_splm FROM applications WHERE id_application = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $application_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $middle_name, $surname, $gender, $dob, $national_id, $residential_city, $statename, $county, $payam, $boma, $date_of_join_splm);
    $stmt->fetch();
    $stmt->close();

    // Generate issue and expiry date
    $issue_date = date('Y-m-d');
    $expiry_date = date('Y-m-d', strtotime('+1 year'));

    // Generate member ID (this can be any unique generation logic)
    $member_id = uniqid('SPLM-');

    // Store ID card information
    $query = "INSERT INTO id_cards (user_id, member_id, first_name, middle_name, surname, gender, dob, national_id, residential_city, statename, county, payam, boma, date_of_join_splm, issue_date, expiry_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isssssssssssssss', $application_id, $member_id, $first_name, $middle_name, $surname, $gender, $dob, $national_id, $residential_city, $statename, $county, $payam, $boma, $date_of_join_splm, $issue_date, $expiry_date);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the admin dashboard
    header("Location: ../views/admin_dashboard.php");
    exit();
} else {
    $_SESSION['error'] = "No application ID provided";
    header("Location: ../views/error_page.php");
    exit();
}
?>
