<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MembrEase</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/design.css">
    <script src="js/scripts.js"></script>
</head>

<body>

    <div class="parent">

       <div class="section-1">
            <video autoplay muted loop playsinline>
                <source src="assets/try.mp4" type="video/mp4">
                Your browser does not support the video tag.
                </video>
        </div>

        <div class="section-2">
            <!-- Section title -->
           <div class="title">Welcome to MembrEase — your PhilHealth companion</div>
           
           <!-- Section subtitle -->
           <div class="subtitle">Enter your login details to access your dashboard.</div>

           <!-- Login form -->
            <form action="verify.php" method="POST">

                <!-- PIN input field -->
                <div class="form">
                <input type="text" name="PIN" autocomplete="off" required />
                <label for="text" class="label-name">
                    <span class="content-name">
                    PhilHealth Identification Number
                    </span>
                </label>
                </div>

                <!-- Password input field -->
                <div class="form">
                <input type="text" name="user_password" autocomplete="off" required />
                <label for="text" class="label-name">
                    <span class="content-name">
                    Password
                    </span>
                </label>
                </div>

                <!-- User help section -->
                <div class="user-help">

                    <!-- Remember me checkbox -->
                    <div class="remember-me">
                        <input type="checkbox">
                        <p>Remember me</p>
                    </div>

                    <!-- Forgot password link -->
                    <div class="forgot-password">
                        <a href="#" onclick="alert('Forgot Password feature isn\'t available yet.'); return false;">Forgot Password?</a>
                    </div>
                </div>

                <!-- Login button -->
                <button class="log-in" type ="submit">Login</button>

                <!-- Register button -->
                <button class="register" 
                type = "button"
                onclick="window.location.href='register.php'">
                No account yet? Register!

                </button>
            </form>


        </div>
    </div>

</body>
</html>