<!-- <!DOCTYPE html>
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

</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MembrEase</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>


    <div class="parent">

        <div class="section-1">
        </div>

        <div class="section-2">

            <div class="title">Log in</div>

            <form action="verify.php" method="POST">
                <div class="pin">
                    <div>PhilHealth Identification Number</div>
                    <input type="text" name="PIN" placeholder="Enter your PIN">
                </div>

                <div class="memberName">
                    <div>Password</div>
                    <input type="text" name="memberName" placeholder="Enter your password"> <!-- take note: memberName == Password -->
                </div>

                <div class="user-help">

                    <div class="remember-me">
                        <input type="checkbox">
                        <p>Remember me</p>
                    </div>
                    
                    <div class="forgot-password">
                        <a href="">Forgot Password?</a>
                    </div>
                </div>
                <button class="log-in" type ="submit">Login</button>
            </form>


            <button class="register" 
            type = "submit"
            onclick="window.location.href='register.php'">
            No account yet? Register!
        
            </button>

            
        </div>

    </div>


</body>
</html>