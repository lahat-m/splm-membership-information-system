<?php
session_start();
include '../config/db_connect.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to submit an application";
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user_id = $_SESSION['user_id']; // Get user ID from session

    $first_name = validate_input($_POST['first_name']);
    $middle_name = validate_input($_POST['middle_name']);
    $surname = validate_input($_POST['surname']);
    $email = validate_input($_POST['email']);
    $phone = validate_input($_POST['phone']);
    $gender = validate_input($_POST['gender']);
    $dob = validate_input($_POST['dob']);
    $national_id = validate_input($_POST['national_id']);
    $residential_city = validate_input($_POST['residential_city']);
    $marital_status = validate_input($_POST['marital_status']);
    $statename = validate_input($_POST['statename']);
    $county = validate_input($_POST['county']);
    $payam = validate_input($_POST['payam']);
    $boma = validate_input($_POST['boma']);
    $profession = validate_input($_POST['profession']);
    $education_level = validate_input($_POST['education_level']);
    $previous_party_affiliation = validate_input($_POST['previous_party_affiliation']);
    $date_of_join_splm = validate_input($_POST['date_of_join_splm']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: ../views/error_page.php");
        exit();
    }

    $dob_pattern = '/^\d{4}-\d{2}-\d{2}$/';
    if (!preg_match($dob_pattern, $dob)) {
        $_SESSION['error'] = "Invalid date of birth format (YYYY-MM-DD)";
        header("Location: ../views/error_page.php");
        exit();
    }

    $sql = "INSERT INTO applications (id_applicant, first_name, middle_name, surname, email, phone, gender, dob, national_id, residential_city, marital_status, statename, county, payam, boma, profession, education_level, previous_party_affiliation, date_of_join_splm)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("issssssssssssssssss", $user_id, $first_name, $middle_name, $surname, $email, $phone, $gender, $dob, $national_id, $residential_city, $marital_status, $statename, $county, $payam, $boma, $profession, $education_level, $previous_party_affiliation, $date_of_join_splm);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Application submitted successfully";
            header("Location: ../views/applicant_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
            header("Location: ../views/error_page.php");
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing statement: " . $conn->error;
        header("Location: ../views/error_page.php");
        exit();
    }

    $conn->close();
} else {
    $_SESSION['error'] = "Invalid request method";
    header("Location: ../views/error_page.php");
    exit();
}
?>
