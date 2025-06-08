<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MembrEase Registration</title>
   
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/register.css" />
</head>
<body>
  <div class="steps">
    <div class="basic">
      <p class="num1">1</p>
      <p>Basic Information</p>
    </div>
    <div class="login">
      <p class="num2">2</p>
      <p>Login Information</p>
    </div>
  </div>

 <form id="registerForm" action="register.php" method="POST" class="info">
    <div class="introRow">
      <h2 class="basicInfo">Help us get to know you better</h2>
      <h4 class="desc">Enter your personal information to create an account.</h4>
    </div>

    <div class="row">
      <div class="PIN">
        <p>PhilHealth Identification Number*</p>
        <input
          type="text" placeholder="PIN" name = "PIN"
          required
        />
      </div>

      <div class="fname">
        <p>First Name*</p>
        <input
          type="text" placeholder="FIRST NAME" name = "first_name"
          required
        />
      </div>
    </div>

    <div class="row">
      <div class="mname">
        <p>Middle Name</p>
        <input
          type="text" placeholder="MIDDLE NAME" name = "middle_name"
        />
      </div>

      <div class="lname">
        <p>Last Name*</p>
        <input
          type="text" placeholder="LAST NAME" name = "last_name"
          required
        />
      </div>
    </div>

    <div class="row">
      <div class="dob">
        <p>Date of Birth*</p>
        <input
          type="date" name="birthdate"
          required
        />
      </div>
      <div class="sex">
        <p>Sex*</p>
        <select name="sex" required>
          <option value="" disabled selected>None</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="email">
        <p>Email Address*</p>
        <input
          type="text" placeholder="EMAIL ADDRESS" name = "emailAdd"
          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
          required
        />
      </div>
      <div class="number">
        <p>Mobile Number*</p>
        <input
          type="text" placeholder="MOBILE NUMBER" name = "mobileNo"
          pattern="[0-9]{10}"
          required
        />
      </div>
    </div>

    <div class="buttonrow">
      <button
        class="haveacc"
        type="button"
        onclick="window.location.href='index.php'"
      >
        Already have an account?
      </button>

      <button class="next" type="submit" name="continue">
        Continue
        <div class="arrow-wrapper">
          <div class="arrow"></div>
        </div>
       


      </button>
    </div>
  </form>

</body>
</html>


<?php
session_start();
include("config.php");

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["register"])) {
    $pin = trim($_POST["pin"]);
    $firstName = trim($_POST["first_name"]);
    $middleName = trim($_POST["middle_name"]);
    $lastName = trim($_POST["last_name"]);
    $dob = $_POST["dob"];
    $sex = $_POST["sex"];
    $email = trim($_POST["email"]);
    $mobile = trim($_POST["mobile"]);
    $password = $_POST["password"];

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email already registered.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (pin, first_name, middle_name, last_name, dob, sex, email, mobile, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $pin, $firstName, $middleName, $lastName, $dob, $sex, $email, $mobile, $hashedPassword);

        if ($stmt->execute()) {
            $success = "Account created! You can now log in.";

            $memberName = trim($firstName . ' ' . $middleName . ' ' . $lastName);

            // Insert into memberDetails table
            $stmt2 = $conn->prepare("INSERT INTO memberDetails (memberName, birthdate, sex, emailAdd, mobileNo) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param("sssss", $memberName, $dob, $sex, $email, $mobile);
            $stmt2->execute();
            $stmt2->close();
        } else {
            $error = "Something went wrong.";
        }

        $stmt->close();
    }

    $check->close();
}