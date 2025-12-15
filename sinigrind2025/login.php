<?php
session_start();

// CONNECT TO DATABASE
$conn = new mysqli("localhost", "root", "", "sinigrind_db");
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $input = $_POST["email"];      // username OR email
    $password = $_POST["password"];

    // 🔥 ADMIN CHEAT (NO DB CHECK)
    if ($input === "admin" && $password === "admin123") {
        $_SESSION["is_admin"] = true;
        $_SESSION["username"] = "admin";
        header("Location: adminpanel.php");
        exit;
    }

    // NORMAL USER LOGIN
    $stmt = $conn->prepare(
        "SELECT user_id, username, password 
         FROM users 
         WHERE username=? OR email=?"
    );
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $username, $dbPassword);

    if ($stmt->num_rows === 1) {
        $stmt->fetch();

        // Plain password check (since you chose no hashing)
        if ($password === $dbPassword) {
            $_SESSION["user_id"] = $user_id;
            $_SESSION["username"] = $username;
            header("Location: lploggedin.php");
            exit;
        } else {
            $errorMsg = "Incorrect password.";
        }
    } else {
        $errorMsg = "User not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="login.css">
</head>
<body>
<div class="login-page">
  <div class="login-box">
    <div class="login-header">Welcome Back</div>
    <div class="login-subtext">Enter your credentials to log in</div>

    <form method="post">
      <div class="login-inputs">
        <label for="email">Email / Username</label>
        <input type="text" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="rememberme">
        <input type="checkbox" id="remember">
        <label for="remember">Remember me</label>
      </div>

      <button class="login-button" type="submit">Login</button>
      <p style="color:red; text-align:center; margin-top:10px;"><?php echo $errorMsg; ?></p>

      <div class="signup-text">
        Don't have an account?
        <a href="signup.php">Sign Up</a>
      </div>
    </form>
  </div>
</div>
</body>
</html>