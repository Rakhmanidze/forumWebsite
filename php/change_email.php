<?php

/**
 * Update user's email and session information.
 *
 * This code updates user's email in the JSON data file and the active session.
 */

session_start();
include_once "User.php";
include_once "find_email.php";

$currentEmail = $_SESSION["email"];
$passedEmail = $_POST["change_email"];

$jsonFilePath = file_get_contents("../data/sign_up.json");
$usersDataJson = json_decode($jsonFilePath);

foreach ($usersDataJson as $user) {
    if ($user->email === $currentEmail) {

        $user->email = $passedEmail;
        $_SESSION["email"] = $passedEmail;
    }
}

file_put_contents("../data/sign_up.json", json_encode($usersDataJson));

header("Location: ../profile.php");