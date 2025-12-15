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

    <form id="loginForm">
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
      <p id="errorMsg" style="color:red; text-align:center; margin-top:10px;"></p>

      <div class="signup-text">
        Don't have an account?
        <a href="signup.php">Sign Up</a>
      </div>
    </form>
  </div>
</div>

<script>
  const loginForm = document.getElementById('loginForm');

  loginForm.addEventListener('submit', function(e){
    e.preventDefault();

    const username = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if(username === 'admin' && password === 'admin123'){
      localStorage.setItem('isAdmin', 'true');
      window.location.href = 'adminpanel.php';
    } else {
      localStorage.removeItem('isAdmin');
      window.location.href = 'lploggedin.php';
    }
  });
</script>
</body>
</html>
