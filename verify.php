<?php
session_start();
include 'config.php'; // Ensure this file contains database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $PIN = $_POST['PIN'];
    $user_password = $_POST['user_password'];

    // Prepare a query to verify user credentials
    $sql = "SELECT * FROM registration WHERE PIN = ? AND user_password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $PIN, $user_password); //also prevents sql injection
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { //"->" means fetch if the app uses a database
        $userData = $result->fetch_assoc(); // Fetch user details

        // Store user details in session
        $_SESSION['userPIN'] = $userData['PIN'];
        $_SESSION['user_password'] = $userData['user_password'];

        header("Location: dashboard.php"); // Redirect to another screen
        exit();
    } else {
        echo "Invalid PIN or Password. Please try again.";
    }

    $stmt->close();
}
?>
