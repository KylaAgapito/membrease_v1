<?php
$servername = "localhost";
$username = "root"; // Adjust if needed
$password = ""; // Adjust if needed
$dbname = "membrease_v2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>