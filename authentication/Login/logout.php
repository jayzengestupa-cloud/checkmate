<?php
// start the session so we can end it
session_start();

// remove all the saved login info (user_id, role, etc.)
session_unset();

// destroy the session completely
session_destroy();

// send the user back to the login page
header("Location: login.php");
exit();
?>