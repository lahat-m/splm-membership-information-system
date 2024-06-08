<?php
session_start();

function check_login($user_type = null) {
    if (!isset($_SESSION['user_id']) || ($user_type && $_SESSION['user_type'] !== $user_type)) {
        header('Location: ../views/login.php');
        exit();
    }
}
?>
