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

      <form action="index.php" method="get">
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
