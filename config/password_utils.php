<?php
// password_utils.php

/**
 * Function to securely hash a password using bcrypt algorithm.
 *
 * @param string $password The password to hash.
 * @return string|bool The hashed password or false on failure.
 */
function hashPassword($password) {
    // Generate a random salt
    $salt = random_bytes(16);

    // Cost factor for the bcrypt algorithm (higher is slower but more secure)
    $cost = 12;

    // Generate the hashed password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost, 'salt' => $salt]);

    return $hashedPassword ?: false;
}

/**
 * Function to verify if a password matches its hashed version.
 *
 * @param string $password The password to verify.
 * @param string $hashedPassword The hashed password to compare against.
 * @return bool True if the password matches the hashed password, false otherwise.
 */
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

/**
 * Function to generate a random password with specified length.
 *
 * @param int $length The length of the generated password.
 * @return string The generated random password.
 */
function generateRandomPassword($length = 12) {
    // Characters allowed in the password
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+{}[]|';

    // Shuffle the characters and get a substring of the desired length
    return substr(str_shuffle($chars), 0, $length);
}

/**
 * Function to validate a password against common criteria.
 *
 * @param string $password The password to validate.
 * @return bool True if the password meets the criteria, false otherwise.
 */
function validatePassword($password) {
    // Check if the password length is at least 8 characters
    if (strlen($password) < 8) {
        return false;
    }

    // Check if the password contains at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    // Check if the password contains at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    // Check if the password contains at least one digit
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }

    // Check if the password contains at least one special character
    if (!preg_match('/[!@#$%^&*()_+{}[\]|]/', $password)) {
        return false;
    }

    return true;
}
?>
