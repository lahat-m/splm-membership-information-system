<?php
session_start();
include '../config/db_connect.php';
include '../config/password_utils.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_identifier = htmlspecialchars(trim($_POST['login_identifier']));
    $password = $_POST['password'];

    // Initialize error message
    $error = '';

    // Check in applicants first
    $stmt = $conn->prepare("SELECT id_applicant, email, password, username FROM applicants WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $login_identifier, $login_identifier);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_applicant, $email, $hashed_password, $username);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            // Create session
            $_SESSION['user_type'] = 'Applicant';
            $_SESSION['user_id'] = $id_applicant;
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            header('Location: ../views/applicant_dashboard.php');
            exit();
        } else {
            $error = "Invalid email/username or password.";
        }
    } else {
        // Check in admins if not found in applicants
        $stmt = $conn->prepare("SELECT id_admin, email, password, username FROM admins WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $login_identifier, $login_identifier);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id_admin, $email, $hashed_password, $username);
            $stmt->fetch();
            
            if (password_verify($password, $hashed_password)) {
                // Create session for admin
                $_SESSION['user_type'] = 'Admin';
                $_SESSION['user_id'] = $id_admin;
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                header('Location: ../views/admin_dashboard.php');
                exit();
            } else {
                $error = "Invalid email/username or password.";
            }
        } else {
            $error = "Invalid email/username or password.";
        }
    }

    $stmt->close();
    $conn->close();

    // If there was an error, set it in the session to display on the login page
    $_SESSION['login_error'] = $error;
    header('Location: ../views/login.php');
    exit();
}
?>