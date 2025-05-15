<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php"); // Redirect to login if not authenticated
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['user']; ?>!</h2>
    <p>You have successfully logged in.</p>
</body>
</html>
