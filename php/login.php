<?php

/**
 * Processes user login and sets session variables if credentials are valid.
 * Redirects to the forum page afterward.
 */

session_start();
include_once "CheckUser.php";
include_once "find_email.php";

$passedEmail = $_POST["login_email"];
$passedPassword = $_POST["login_PW"];

$error_l = validateLoginData($passedEmail, $passedPassword);

if ($error_l) {
    header("Location: ../forum.php?error_l=" . urlencode($error_l) . "&email_login=" . urlencode($passedEmail));
    exit();
}

/**
 * Verify user login credentials against the data stored in the JSON file.
 *
 * @param string $email - User's email.
 * @param string $password - User's password.
 *
 * @return bool - True if the login credentials are valid, false otherwise.
 */
function verifyLoginPassword($email, $password)
{
    $jsonFilePath = "../data/sign_up.json";
    $usersDataJson = json_decode(file_get_contents($jsonFilePath));

    foreach ($usersDataJson as $user) {
        if (isset($user->email) && isset($user->password) && $user->email == $email) {
            if (password_verify($password, $user->password)) {
                return true;
            }
            break;
        }
    }

    return false;
}

/**
 * Validates login data.
 * @param string $email - User's email
 * @param string $password - User's password
 * @return string|null - Error message if validation fails, otherwise null
 */

 function validateLoginData($email, $password)
 {
     if (empty($email) || strlen(trim($password)) === 0) {
         return "Email and password can't be empty";
     }

     if (strlen($email) > 30) {
        return 'Email too long';
    }

    if (strlen($password) > 20) {
        return 'Password too long';
    }
 
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         return 'Invalid email format';
     }
 
     if (preg_match("/[^a-zA-Z0-9]+$/", $password)) {
         return 'Password: letters and numbers only';
     }
 
     if (!emailIsInJson($email)) {
         return "Email doesn't ";
     }
    
     if (!verifyLoginPassword($email, $password)) {
        return "Wrong password";
    }

     return null;
 }

$jsonFilePath = file_get_contents("../data/sign_up.json");
$usersDataJson = json_decode($jsonFilePath);

$checkedUserData  = new CheckUser(false, false);
$nameOfPhoto = "";
$userId = 0;
foreach ($usersDataJson as $user) {

    if ($user->email  == $passedEmail) {
        $checkedUserData->emailCheck = true;

        if (password_verify($passedPassword, $user->password)) {
            $checkedUserData->passwordCheck = true;
            $nameOfPhoto = $user -> nameOfPhoto;
            $userId = $user->id;
        }
        break;
    }
}

if ($checkedUserData->emailCheck && $checkedUserData->passwordCheck) {
    $_SESSION["isLoggedIn"] = "true";
    $_SESSION["userId"] = $userId;
    $_SESSION["email"] = $passedEmail;
    $_SESSION["nameOfPhoto"] = $nameOfPhoto;
}

header("Location: ../forum.php");