<?php
session_start();
include '../config/db_connect.php';
include '../config/password_utils.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user inputs
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $middle_name = htmlspecialchars(trim($_POST['middle_name']));
    $surname = htmlspecialchars(trim($_POST['surname']));
    $dob = htmlspecialchars(trim($_POST['dob']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $national_id = htmlspecialchars(trim($_POST['national_id']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $user_type = htmlspecialchars(trim($_POST['user_type']));

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['register_error'] = "Passwords do not match.";
        header('Location: ../views/register.php');
        exit();
    }

    // Check if email or username already exists
    $stmt = $conn->prepare("SELECT email, username FROM applicants WHERE email = ? OR username = ? UNION SELECT email, username FROM admins WHERE email = ? OR username = ?");
    $stmt->bind_param("ssss", $email, $username, $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['register_error'] = "Email or Username already exists.";
        $stmt->close();
        $conn->close();
        header('Location: ../views/register.php');
        exit();
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the appropriate table based on user type
    if ($user_type === 'Admin') {
        $stmt = $conn->prepare("INSERT INTO admins (first_name, middle_name, surname, dob, gender, national_id, email, phone, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $first_name, $middle_name, $surname, $dob, $gender, $national_id, $email, $phone, $username, $hashed_password);
    } else {
        $stmt = $conn->prepare("INSERT INTO applicants (first_name, middle_name, surname, dob, gender, national_id, email, phone, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $first_name, $middle_name, $surname, $dob, $gender, $national_id, $email, $phone, $username, $hashed_password);
    }

    if ($stmt->execute()) {
        $_SESSION['register_success'] = "Registration successful!";
        header('Location: ../views/login.php');
    } else {
        $_SESSION['register_error'] = "Registration failed. Please try again.";
        header('Location: ../views/register.php');
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
