<?php
session_start();

if (!isset($_SESSION['PIN'])) {
    header("Location: register.php");
    exit();
}

include("config.php"); // Make sure this file connects to your DB

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["create"])) {
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Password validation (add your own as needed)
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[`~!@#$%^&*()\-_=+\[\]{}|;:'\"<>,.\/?]).{8,32}$/";
    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (!preg_match($pattern, $password)) {
        $error = "Password does not meet requirements.";
    } else {
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $hashedPassword = $password;
        $memberName = trim($_SESSION['first_name'] . ' ' . $_SESSION['middle_name'] . ' ' . $_SESSION['last_name']);

        $stmt = $conn->prepare("INSERT INTO registration (PIN, user_password, memberName, birthdate, sex, mobileNo, emailAdd) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sssssss",
            $_SESSION['PIN'],
            $hashedPassword,
            $memberName,
            $_SESSION['birthdate'],
            $_SESSION['sex'],
            $_SESSION['mobileNo'],
            $_SESSION['emailAdd']
        );

        if ($stmt->execute()) {
            // Clear session data if needed
            session_unset();
            session_destroy();
            echo "<script>
                alert('Registration complete! Returning to login form.');
                window.location.href = 'index.php';
            </script>";
            exit();   
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <title>MembrEase Login Information</title>
  <link rel="stylesheet" href="css/stylelog.css"> 
</head>
<body>
    <div class="steps">
      <div class="basic">
        <p class="num">1</p>
        <p>Basic Information</p>
      </div>
      <div class="login">
        <p class="num">2</p>
        <p>Login Information</p>
      </div>
  </div>

   <div class="info">
      <div class="introRow">
          <h2 class="basicInfo">Unlock your Experience</h2>
          <h4 class="desc">Complete your setup to start exploring.</h4>
      </div>
<form method="POST" action="password.php">
    <?php if (isset($error)): ?>
      <div style="color:red; margin-bottom:10px;"><?php echo $error; ?></div>
    <?php endif; ?>
      <div class="password">
    <div class="passreq">
      <div class="description">
        <p>Password must meet the following requirements:</p>
      </div>
      <div class="req">
        <p> • Minimum of 8 chars </p>
        <p>  • Maximum of 32 chars</p>
        <p>  • Must contain at least one digit (0-9)</p>
        <p>  • Must contain at least one uppercase letter (A-Z)</p>
        <p> • Must contain at least one lowercase letter (a-z)</p>
        <p> • Must contain at least one special chars (` ~ ! @ # $ % ^ & * ( ) - _ = + [ ] { } | ; : ' " < > , . / ?)</p>
      </div>
    </div>
    <div class="prefpass">
      <p>Preferred Password</p>
      <input type="password" name="password" placeholder="PREFERRED PASSWORD" required>
    </div>
    <div class="confirm">
      <p>Confirm Password</p>
      <input type="password" name="confirm_password" placeholder="CONFIRM PASSWORD" required>
    </div>
    <button class="create" type="submit" name="create">
      Create Account
      <div class="arrow-wrapper">
        <div class="arrow"></div>
      </div>
    </button>
  </div>
</form>

    <!-- <script>

    window.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('updated') === '1') {
            alert('Information added successfully!');
            window.location.href = 'contributorDisplay.php';
        }
    });
    </script> -->
    
</body>
</html>