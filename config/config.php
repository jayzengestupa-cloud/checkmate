<?php

$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_db = "checkmate_db";

$conn = new mysqli(
    $db_server,
    $db_username,
    $db_password,
    $db_db
);

if ($conn->connect_error) {
    die("Failed connection: " . $conn->connect_error);
}

?>