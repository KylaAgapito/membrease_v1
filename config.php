<?php
$servername = "localhost";
$username = "root"; // Adjust if needed
$password = ""; // Adjust if needed
$dbname = "membreasev2"; //NAME OF THE DATABASE! The name of **this** php project is membrease_v1!

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>