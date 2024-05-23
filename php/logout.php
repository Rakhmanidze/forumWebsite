<?php

/**
 * Log out the user by clearing session data.
 *
 * This code unsets and destroys the user's session, effectively logging them out.
 */

session_start();

unset($_SESSION["userId"]);
unset($_SESSION["isLoggedIn"]);
unset($_SESSION["email"]);
unset($_SESSION["nameOfPhoto"]);
session_destroy();

echo json_encode(true);
