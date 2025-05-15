<?php
session_start();
include 'config.php'; // Ensure this file contains database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $PIN = $_POST['PIN'];
    $memberName = $_POST['memberName'];

    // Prepare a query to verify user credentials
    $sql = "SELECT * FROM person WHERE PIN = ? AND memberName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $PIN, $memberName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc(); // Fetch user details

        // Store user details in session
        $_SESSION['userPIN'] = $userData['PIN'];
        $_SESSION['userName'] = $userData['memberName'];

        header("Location: welcome.php"); // Redirect to another screen
        exit();
    } else {
        echo "Invalid PIN or Name. Please try again.";
    }

    $stmt->close();
}
?>
