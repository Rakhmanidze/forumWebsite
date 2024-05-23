<?php

/**
 * Check if an email exists in the JSON data.
 *
 * @param string $email The email to check.
 *
 * @return bool True if the email exists in the JSON data, false otherwise.
 */

function emailIsInJson($email) {
    $usersDataJson = file_get_contents('../data/sign_up.json');
    $usersDecodedDataJson = json_decode($usersDataJson);
 
    foreach ($usersDecodedDataJson as $user) {
        if ($user->email == $email) {
            return true;
        }
    }

    return false;
}
