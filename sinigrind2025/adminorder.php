<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Orders - SiniGrind</title>
<style>
  body { font-family: Arial; background: #e6e2d7; margin:0; padding:20px; }
  h1 { text-align:center; margin-top:0; }
  table { width:90%; margin:20px auto; border-collapse: collapse; background:#fff; border-radius:10px; overflow:hidden; }
  th, td { padding:12px; text-align:center; border-bottom:1px solid #ccc; }
  th { background:#f2ae1d; color:#fff; }
  input[type="number"] { width:60px; padding:5px; }
  button { padding:6px 10px; border:none; border-radius:5px; cursor:pointer; }
  .remove-btn { background:#ff4d4d; color:#fff; }
  .complete-btn { background:#4CAF50; color:#fff; }
  .logout { display:block; margin:20px auto; padding:10px 20px; background:#ff4d4d; color:#fff; border:none; border-radius:5px; cursor:pointer; }
</style>
</head>
<body>

<h1>Admin Orders</h1>

<table id="ordersTable">
  <thead>
    <tr>
      <th>Order ID</th>
      <th>Customer</th>
      <th>Product</th>
      <th>Quantity</th>
      <th>Total</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <!-- Orders will populate here -->
  </tbody>
</table>

<button class="logout" onclick="logoutAdmin()">Logout</button>

<script>
  // Mock orders for admin view
  let orders = [
    {id:1001, customer:"Juan Dela Cruz", product:"Arabica Coffee", qty:2, price:225, status:"Pending"},
    {id:1002, customer:"Maria Santos", product:"Matcha Coffee", qty:1, price:415, status:"Pending"}
  ];

  // Check admin access
  if(localStorage.getItem('isAdmin') !== 'true') {
    alert('You are not authorized!');
    window.location.href = 'adminlogin.php';
  }

  function renderOrders() {
    const tbody = document.querySelector('#ordersTable tbody');
    tbody.innerHTML = '';
    orders.forEach((order, index) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${order.id}</td>
        <td>${order.customer}</td>
        <td>${order.product}</td>
        <td><input type="number" value="${order.qty}" min="1" onchange="updateQty(${index}, this.value)"></td>
        <td>₱${order.qty * order.price}</td>
        <td>${order.status}</td>
        <td>
          <button class="complete-btn" onclick="markCompleted(${index})">Complete</button>
          <button class="remove-btn" onclick="removeOrder(${index})">Remove</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  function updateQty(index, newQty) {
    orders[index].qty = parseInt(newQty);
    renderOrders();
  }

  function markCompleted(index) {
    orders[index].status = "Completed";
    renderOrders();
  }

  function removeOrder(index) {
    orders.splice(index,1);
    renderOrders();
  }

  function logoutAdmin() {
    localStorage.removeItem('isAdmin');
    window.location.href = 'adminlogin.php';
  }

  renderOrders();
</script>

</body>
</html>
