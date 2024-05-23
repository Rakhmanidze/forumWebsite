<?php

/**
 * Checks if an email exists in the user data JSON file.
 *
 * Input: $passedEmail - Decoded JSON email input.
 * Output: $emailResult - Boolean indicating email existence, JSON-encoded.
 */

include_once "find_email.php";

$passedEmail = json_decode(file_get_contents("php://input"), true);

$emailResult = emailIsInJson($passedEmail);

echo json_encode($emailResult);
