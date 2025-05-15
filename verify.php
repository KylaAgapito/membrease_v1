<?php
session_start();
include 'config.php'; // Ensure this file contains database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $PIN = $_POST['PIN'];
    $memberName = $_POST['memberName'];

    // Establish database connection
    $conn = new mysqli("localhost", "root", "", "membrease_v2");

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a query to verify user credentials
    $sql = "SELECT * FROM person WHERE PIN = ? AND memberName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $PIN, $memberName);
    $stmt->execute();
    $result = $stmt->get_result();

    // If user exists, redirect to welcome page
    if ($result->num_rows > 0) {
        $_SESSION['user'] = $memberName;
        header("Location: welcome.php"); // Redirect to another screen
        exit();
    } else {
        echo "Invalid PIN or Name. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>