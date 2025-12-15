<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - SiniGrind</title>
<style>
  body { font-family: Arial; background: #e6e2d7; margin:0; padding:0; display:flex; justify-content:center; align-items:center; height:100vh; }
  .login-box { background:#fff; padding:40px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); width:300px; text-align:center; }
  input { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
  button { padding:10px 20px; border:none; border-radius:5px; background:#f2ae1d; color:#fff; cursor:pointer; font-size:16px; }
</style>
</head>
<body>

<div class="login-box">
  <h2>Admin Login (Mock)</h2>
  <input type="text" id="username" placeholder="Username">
  <input type="password" id="password" placeholder="Password">
  <button onclick="adminLogin()">Login</button>
  <p id="errorMsg" style="color:red;"></p>
</div>

<script>
  function adminLogin() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Fake credentials para sa mockup
    if(username === 'admin' && password === 'admin123') {
      // Mark admin in localStorage
      localStorage.setItem('isAdmin', 'true');
      window.location.href = 'adminpanel.php'; // Redirect to admin page
    } else {
      document.getElementById('errorMsg').textContent = 'Invalid credentials!';
    }
  }
</script>

</body>
</html>
