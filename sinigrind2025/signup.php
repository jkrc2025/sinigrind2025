<?php
session_start();

$conn = new mysqli("localhost", "root", "", "sinigrind_db");
if ($conn->connect_error) {
    die("DB connection failed");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm-password"];

    if ($password !== $confirm) {
        die("Passwords do not match");
    }

    $now = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("
        INSERT INTO users (username, password, email, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssss", $username, $password, $email, $now, $now);

    if ($stmt->execute()) {
        $_SESSION["user_id"] = $stmt->insert_id;
        $_SESSION["username"] = $username;
        header("Location: login.php");
        exit;
    } else {
        echo "Error creating account";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up</title>
<link rel="stylesheet" href="signup.css">
</head>
<body>
<div class="sign-up">
  <div class="login">
    <div class="text-wrapper">Create Account</div>
    <div class="login-text">Fill in your details to sign up</div>

    <form method="post">
      <div class="INPUT">
        <label class="text-wrapper-2" for="username">Username</label>
        <input class="username-input" type="text" id="username" name="username" required>

        <label class="text-wrapper-3" for="email">Email</label>
        <input class="pass-input" type="email" id="email" name="email" required>

        <label class="text-wrapper-4" for="password">Password</label>
        <input class="pass-input-2" type="password" id="password" name="password" required>

        <label class="text-wrapper-5" for="confirm-password">Confirm Password</label>
        <input class="pass-input-3" type="password" id="confirm-password" name="confirm-password" required>
      </div>

      <div class="rememberme">
        <input type="checkbox" class="check-box" id="terms" required>
        <label for="terms">I agree to the Terms & Conditions</label>
      </div>

      <div class="buttons">
        <div class="login-button-box">
          <button class="login-button" type="submit">Sign Up</button>
        </div>
      </div>

      <div class="new-user">
        Already have an account?
        <a class="sign-up-link" href="login.php">Login</a>
      </div>
    </form>
  </div>
</div>
</body>
</html>