<!DOCTYPE html>
<html>

<head>
    <title>MembrEase V1</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h1>Welcome to MembrEase V1!</h1>
    <h2>Login your PhilHealth Account</h2>
    
    <form action="verify.php" method="POST">
        <label for="PIN">PIN:</label>
        <input type="text" name="PIN" placeholder="Enter your PIN">
        <label for="memberName">Member Name:</label>
        <input type="text" name="memberName" placeholder="First Name M.I. Last Name">
        <button type="submit">Login</button>
    </form>

</body>

</html>