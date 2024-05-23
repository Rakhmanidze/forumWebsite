<?php

/**
 * Handles user login verification against data stored in a JSON file.
 */

session_start();

include_once "User.php";

$inputData = json_decode(file_get_contents("php://input"), true);
$passedEmail = $inputData["email"];
$passedPassword = $inputData["password"];

$result = verifyLoginPasswordInJson($passedEmail, $passedPassword);

echo json_encode($result);

// some validation TODO

/**
 * Verify user login credentials against the data stored in the JSON file.
 *
 * @param string $email - User's email.
 * @param string $password - User's password.
 *
 * @return bool - True if the login credentials are valid, false otherwise.
 */
function verifyLoginPasswordInJson($email, $password) {
    $result = false;

    // get data from the JSON file and decode them
    $usersDataJson = json_decode(file_get_contents("../data/sign_up.json"));

    foreach ($usersDataJson as $user) {
        if ($user->email === $email) {
            if (password_verify($password, $user->password)) {
                $result = true;
            }
            break;
        }
    }

    return $result;
}









