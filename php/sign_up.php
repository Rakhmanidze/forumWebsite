<?php

/**
 * Handles user registration, including data validation, photo upload, and session management.
 * Redirects to the forum page after successful registration.
 */

session_start();
include_once "User.php";
include_once "find_email.php";

$passedEmail = $_POST["email"];
$passedPassword = $_POST["password"];
$secondPassword = $_POST["secondPassword"];

$folderOfPhoto = "../data/user_img/";
$nameOfPhoto = "";

$error = validateRegistrationData($passedEmail, $passedPassword, $secondPassword);

if ($error) {
    header("Location: ../forum.php?error=" . urlencode($error) . "&email=" . urlencode($passedEmail));
    exit();
}


/**
 * Validates registration data.
 * @param string $email - User's email
 * @param string $password - User's password
 * @param string $secondPassword - User's confirmed password
 * @return string|null - Error message if validation fails, otherwise null
 */
function validateRegistrationData($email, $password, $secondPassword)
{
    if (empty($email) || strlen(trim($password)) === 0 || strlen(trim($secondPassword)) === 0) {
        return 'Email and password cannot be empty';
    }

    if (strlen($email) > 30) {
        return 'Email too long';
    }

    if (strlen($password) > 20 || strlen($secondPassword) > 20) {
        return 'Password too long';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email format';
    }

    if ($password !== $secondPassword) {
        return 'Passwords do not match';
    }

    if (preg_match("/[^a-zA-Z0-9]+$/", $password) || preg_match("/[^a-zA-Z0-9]+$/", $secondPassword)) {
        return 'Password: letters and numbers only';
    }

    
    if (emailIsInJson($email)) {
        return 'Email already exists';
    }

    if ($_FILES["image"]["error"] != UPLOAD_ERR_NO_FILE) {
        $photoExtension = pathinfo(basename($_FILES["image"]["name"]), PATHINFO_EXTENSION);

        // Check if the file extension is allowed
        $allowedExtensions = array("jpg", "png");
        if (!in_array(strtolower($photoExtension), $allowedExtensions)) {
            return 'Allowed files: jpg, png.';
        }
    }

    return null;
}

$usersDataJson = file_get_contents('../data/sign_up.json');
$usersDecodedDataJson = json_decode($usersDataJson);

$userId = 1;
if (count($usersDecodedDataJson) != 0) {
    $userId = $usersDecodedDataJson[count($usersDecodedDataJson) - 1] -> id + 1;
}

if ($_FILES["image"]["error"] != UPLOAD_ERR_NO_FILE) {
    $photoExtension = pathinfo(basename($_FILES["image"]["name"]), PATHINFO_EXTENSION);

    $nameOfPhoto = $userId . "." . $photoExtension;
    move_uploaded_file($_FILES["image"]["tmp_name"], $folderOfPhoto . $nameOfPhoto);
}

$hashedPassword = password_hash($passedPassword, PASSWORD_DEFAULT);

$usersDecodedDataJson[] = new User($userId,$passedEmail,$hashedPassword,$nameOfPhoto);

file_put_contents("../data/sign_up.json",json_encode($usersDecodedDataJson));

$_SESSION["isLoggedIn"] = "true";
$_SESSION["userId"] = $userId;
$_SESSION["email"] = $passedEmail;
$_SESSION["nameOfPhoto"] = $nameOfPhoto;

header("Location: ../forum.php");