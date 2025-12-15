<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - SiniGrind</title>
<style>
  body { font-family: Arial; background:#e6e2d7; margin:0; padding:20px; }
  h1 { text-align:center; }
  table { width:90%; margin:20px auto; border-collapse: collapse; background:#fff; border-radius:10px; overflow:hidden; }
  th, td { padding:12px; text-align:center; border-bottom:1px solid #ccc; }
  th { background:#f2ae1d; color:#fff; }
  .logout { display:block; margin:20px auto; padding:10px 20px; background:#ff4d4d; color:#fff; border:none; border-radius:5px; cursor:pointer; }
</style>
</head>
<body>

<h1>Admin Dashboard</h1>

<table>
  <thead>
    <tr>
      <th>Order ID</th>
      <th>Customer</th>
      <th>Product</th>
      <th>Quantity</th>
      <th>Total</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1001</td>
      <td>Juan Dela Cruz</td>
      <td>Arabica Coffee</td>
      <td>2</td>
      <td>₱450</td>
      <td>Pending</td>
    </tr>
    <tr>
      <td>1002</td>
      <td>Maria Santos</td>
      <td>Matcha Coffee</td>
      <td>1</td>
      <td>₱415</td>
      <td>Completed</td>
    </tr>
  </tbody>
</table>

<button class="logout" onclick="logoutAdmin()">Logout</button>

<script>
  // Check if admin is logged in
  if(localStorage.getItem('isAdmin') !== 'true') {
    alert('You are not authorized!');
    window.location.href = 'adminlogin.php';
  }

  function logoutAdmin() {
    localStorage.removeItem('isAdmin');
    window.location.href = 'adminlogin.php';
  }
</script>

</body>
</html>
