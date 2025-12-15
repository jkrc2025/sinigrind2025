<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - SiniGrind</title>
<style>
  body { margin:0; font-family: Arial; background:#e6e2d7; display:flex; height:100vh; }
  .sidebar { width:250px; background:#f2ae1d; display:flex; flex-direction:column; padding-top:20px; }
  .sidebar a { padding:15px 20px; color:#fff; text-decoration:none; display:block; transition:0.2s; }
  .sidebar a:hover, .sidebar a.active { background:#e58b0b; }
  .content { flex:1; padding:20px; overflow-y:auto; }
  h1 { margin-top:0; }
  table { width:100%; border-collapse: collapse; margin-top:20px; }
  th, td { padding:10px; text-align:center; border-bottom:1px solid #ccc; }
  th { background:#f2ae1d; color:#fff; }
  select, input { padding:5px; border-radius:5px; border:1px solid #ccc; }
  button { padding:5px 10px; border:none; border-radius:5px; cursor:pointer; }
  .low-stock { color:#ff9900; font-weight:bold; }
  .out-stock { color:#ff4d4d; font-weight:bold; }
  .active-stock { color:#4CAF50; font-weight:bold; }
  canvas { margin-top:20px; }
</style>
</head>
<body>

<div class="sidebar">
  <a href="#" class="active" onclick="showView('dashboard')">Dashboard</a>
  <a href="#" onclick="showView('customers')">Customers</a>
  <a href="#" onclick="showView('products')">Products</a>
  <a href="#" onclick="showView('orders')">Orders</a>
  <a href="#" onclick="showView('sales')">Sales Report</a>
  <a href="#" onclick="logoutAdmin()">Logout</a>
</div>

<div class="content">
  <!-- Dashboard -->
  <div id="dashboard">
    <h1>Dashboard</h1>
    <p>Total Products: <span id="totalProducts"></span></p>
    <p>Total Orders: <span id="totalOrders"></span></p>
    <p>Total Revenue: ₱<span id="totalRevenue"></span></p>
    <p>Products Sold: <span id="productsSold"></span></p>
    <h3>Order Status</h3>
    <p>Ready for Pickup: <span id="readyPickup"></span></p>
    <p>Processing: <span id="processing"></span></p>
    <p>Completed: <span id="completed"></span></p>
    <p>Cancelled: <span id="cancelled"></span></p>
    <h3>Stock Status</h3>
    <p>Low Stock: <span id="lowStock"></span></p>
    <p>Out of Stock: <span id="outStock"></span></p>
    <p>Active Stock: <span id="activeStock"></span></p>
  </div>

  <!-- Customers -->
  <div id="customers" style="display:none">
    <h1>Customers</h1>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Contact</th>
          <th>Email</th>
          <th>Payment Method</th>
          <th>Last Ordered</th>
        </tr>
      </thead>
      <tbody id="customersTable"></tbody>
    </table>
  </div>

  <!-- Products -->
  <div id="products" style="display:none">
    <h1>Products</h1>
    <table>
      <thead>
        <tr>
          <th>SKU</th>
          <th>Product</th>
          <th>Stock</th>
          <th>Price</th>
          <th>Status</th>
          <th>Update Stock</th>
        </tr>
      </thead>
      <tbody id="productsTable"></tbody>
    </table>
  </div>

  <!-- Orders -->
  <div id="orders" style="display:none">
    <h1>Orders</h1>
    <table>
      <thead>
        <tr>
          <th>Reference #</th>
          <th>Customer</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Pickup Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="ordersTable"></tbody>
    </table>
  </div>

  <!-- Sales Report -->
  <div id="sales" style="display:none">
    <h1>Sales Report</h1>
    <canvas id="salesChart" width="400" height="200"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Check admin
  if(localStorage.getItem('isAdmin') !== 'true'){
    alert('You are not authorized!');
    window.location.href = 'login.php';
  }

  // Mock data
  const products = [
    {sku:'C001', name:"Arabica Coffee", stock:50, price:225},
    {sku:'C002', name:"Robusta Coffee", stock:30, price:180},
    {sku:'C003', name:"Matcha Coffee", stock:2, price:415},
    {sku:'C004', name:"Mocha Coffee", stock:0, price:350},
    {sku:'C005', name:"Latte Coffee", stock:60, price:300},
    {sku:'C006', name:"Espresso Coffee", stock:5, price:250},
    {sku:'C007', name:"Cappuccino", stock:35, price:280},
    {sku:'C008', name:"Macchiato", stock:15, price:320}
  ];

  const customers = [
    {name:"Juan Dela Cruz", contact:"09171234567", email:"juan@example.com", payment:"Gcash", lastOrdered:"2025-12-10"},
    {name:"Maria Santos", contact:"09179876543", email:"maria@example.com", payment:"Credit Card", lastOrdered:"2025-12-12"}
  ];

  const orders = [
    {ref:"ORD1001", customer:"Juan Dela Cruz", product:"Arabica Coffee", qty:2, price:225, pickup:"2025-12-15", status:"Ready for Pickup"},
    {ref:"ORD1002", customer:"Maria Santos", product:"Matcha Coffee", qty:1, price:415, pickup:"2025-12-16", status:"Processing"},
    {ref:"ORD1003", customer:"Juan Dela Cruz", product:"Latte Coffee", qty:3, price:300, pickup:"2025-12-17", status:"Completed"}
  ];

  // Utility functions
  function getStockStatus(stock){
    if(stock===0) return 'Out of Stock';
    if(stock<=5) return 'Low Stock';
    return 'Active';
  }

  // Render Dashboard
  function renderDashboard(){
    document.getElementById('totalProducts').textContent = products.length;
    document.getElementById('totalOrders').textContent = orders.length;
    document.getElementById('totalRevenue').textContent = orders.reduce((sum,o)=>sum+o.qty*o.price,0);
    document.getElementById('productsSold').textContent = orders.reduce((sum,o)=>sum+o.qty,0);

    document.getElementById('readyPickup').textContent = orders.filter(o=>o.status==='Ready for Pickup').length;
    document.getElementById('processing').textContent = orders.filter(o=>o.status==='Processing').length;
    document.getElementById('completed').textContent = orders.filter(o=>o.status==='Completed').length;
    document.getElementById('cancelled').textContent = orders.filter(o=>o.status==='Cancelled').length;

    document.getElementById('lowStock').textContent = products.filter(p=>p.stock>0 && p.stock<=5).length;
    document.getElementById('outStock').textContent = products.filter(p=>p.stock===0).length;
    document.getElementById('activeStock').textContent = products.filter(p=>p.stock>5).length;
  }

  // Render Customers
  function renderCustomers(){
    const tbody = document.getElementById('customersTable');
    tbody.innerHTML='';
    customers.forEach(c=>{
      const tr=document.createElement('tr');
      tr.innerHTML=`<td>${c.name}</td><td>${c.contact}</td><td>${c.email}</td><td>${c.payment}</td><td>${c.lastOrdered}</td>`;
      tbody.appendChild(tr);
    });
  }

  // Render Products
  function renderProducts(){
    const tbody = document.getElementById('productsTable');
    tbody.innerHTML='';
    products.forEach((p,i)=>{
      const tr=document.createElement('tr');
      const status = getStockStatus(p.stock);
      const statusClass = status==='Low Stock' ? 'low-stock' : status==='Out of Stock' ? 'out-stock':'active-stock';
      tr.innerHTML=`<td>${p.sku}</td><td>${p.name}</td><td>${p.stock}</td><td>₱${p.price}</td>
      <td class="${statusClass}">${status}</td>
      <td>
        <select onchange="updateStock(${i}, this.value)">
          <option value="">Select Stock</option>
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
        </select>
      </td>`;
      tbody.appendChild(tr);
    });
  }

  function updateStock(index, value){
    if(value!==''){
      products[index].stock=parseInt(value);
      renderProducts();
      renderDashboard();
    }
  }

  // Render Orders
  function renderOrders(){
    const tbody = document.getElementById('ordersTable');
    tbody.innerHTML='';
    orders.forEach((o,i)=>{
      const tr=document.createElement('tr');
      tr.innerHTML=`<td>${o.ref}</td><td>${o.customer}</td><td>${o.product}</td><td>${o.qty}</td>
      <td>₱${o.qty*o.price}</td><td>${o.pickup}</td>
      <td>
        <select onchange="updateOrderStatus(${i}, this.value)">
          <option value="Processing" ${o.status==='Processing'?'selected':''}>Processing</option>
          <option value="Ready for Pickup" ${o.status==='Ready for Pickup'?'selected':''}>Ready for Pickup</option>
          <option value="Completed" ${o.status==='Completed'?'selected':''}>Completed</option>
          <option value="Cancelled" ${o.status==='Cancelled'?'selected':''}>Cancelled</option>
        </select>
      </td>`;
      tbody.appendChild(tr);
    });
  }

  function updateOrderStatus(index, status){
    orders[index].status=status;
    renderOrders();
    renderDashboard();
  }

  // Render Sales Report
  function renderSalesChart(){
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx,{
      type:'bar',
      data:{
        labels: products.map(p=>p.name),
        datasets:[{
          label:'Units Sold',
          data: orders.map(o=>o.qty),
          backgroundColor:'rgba(246, 174, 29, 0.7)'
        }]
      },
      options:{ responsive:true, plugins:{legend:{display:false}} }
    });
  }

  // Sidebar Navigation
  function showView(view){
    ['dashboard','customers','products','orders','sales'].forEach(v=>{
      document.getElementById(v).style.display = (v===view)?'block':'none';
    });
    document.querySelectorAll('.sidebar a').forEach(a=>a.classList.remove('active'));
    event.target.classList.add('active');

    if(view==='dashboard') renderDashboard();
    if(view==='customers') renderCustomers();
    if(view==='products') renderProducts();
    if(view==='orders') renderOrders();
    if(view==='sales') renderSalesChart();
  }

  function logoutAdmin(){
    localStorage.removeItem('isAdmin');
    window.location.href='login.php';
  }

  // Initial load
  renderDashboard();
</script>

</body>
</html>
