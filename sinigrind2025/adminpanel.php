<?php
session_start();
if(!isset($_SESSION['is_admin'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "sinigrind_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

// --- Customers ---
$customers = [];
$sql = "SELECT u.username, u.email, p.payment_method, MAX(o.date_ordered) AS lastOrdered
        FROM users u
        LEFT JOIN orders o ON u.user_id = o.user_id
        LEFT JOIN payments p ON o.order_id = p.order_id
        GROUP BY u.user_id";
$res = $conn->query($sql);
if($res){
    while($row = $res->fetch_assoc()){
        $customers[] = $row;
    }
}

// --- Products ---
$products = [];
$sql = $sql = "SELECT p.item_id, p.sku, p.name, p.price, s.quantity, s.status
        FROM products p
        LEFT JOIN stock s ON p.item_id = s.item_id";
$res = $conn->query($sql);
if($res){
    while($row = $res->fetch_assoc()){
        $products[] = $row;
    }
}

// --- Orders ---
$orders = [];
$sql = "SELECT o.order_id, o.item_quantity, o.order_status, o.date_ordered, o.date_claimed,
        u.username AS customer_name, p.name AS product_name, p.price
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        JOIN products p ON o.item_id = p.item_id";
$res = $conn->query($sql);
if($res){
    while($row = $res->fetch_assoc()){
        $orders[] = $row;
    }
}

// Encode for JS
$customers_json = json_encode($customers);
$products_json = json_encode($products);
$orders_json = json_encode($orders);
?>

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
input { padding:5px; border-radius:5px; border:1px solid #ccc; width:60px; text-align:center; }
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

  <div id="customers" style="display:none">
    <h1>Customers</h1>
    <table>
      <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Payment Method</th>
          <th>Last Ordered</th>
        </tr>
      </thead>
      <tbody id="customersTable"></tbody>
    </table>
  </div>

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

  <div id="sales" style="display:none">
    <h1>Sales Report</h1>
    <canvas id="salesChart" width="400" height="200"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const customers = <?php echo $customers_json; ?>;
let products = <?php echo $products_json; ?>;
const orders = <?php echo $orders_json; ?>;

// --- Utilities ---
function getStockStatus(stock){
    if(stock==0) return 'Out of Stock';
    if(stock<=5) return 'Low Stock';
    return 'Active';
}

// --- Render Dashboard ---
function renderDashboard(){
    document.getElementById('totalProducts').textContent = products.length;
    document.getElementById('totalOrders').textContent = orders.length;
    document.getElementById('totalRevenue').textContent = orders.reduce((sum,o)=>sum+o.price*o.item_quantity,0);
    document.getElementById('productsSold').textContent = orders.reduce((sum,o)=>sum+o.item_quantity,0);

    document.getElementById('readyPickup').textContent = orders.filter(o=>o.order_status==='Ready for Pickup').length;
    document.getElementById('processing').textContent = orders.filter(o=>o.order_status==='Processing').length;
    document.getElementById('completed').textContent = orders.filter(o=>o.order_status==='Completed').length;
    document.getElementById('cancelled').textContent = orders.filter(o=>o.order_status==='Cancelled').length;

    document.getElementById('lowStock').textContent = products.filter(p=>p.stock>0 && p.stock<=5).length;
    document.getElementById('outStock').textContent = products.filter(p=>p.stock==0).length;
    document.getElementById('activeStock').textContent = products.filter(p=>p.stock>5).length;
}

// --- Render Customers ---
function renderCustomers(){
    const tbody = document.getElementById('customersTable');
    tbody.innerHTML='';
    customers.forEach(c=>{
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${c.username}</td><td>${c.email}</td><td>${c.payment_method||'-'}</td><td>${c.lastOrdered||'-'}</td>`;
        tbody.appendChild(tr);
    });
}

// --- Render Products ---
function renderProducts(){
    const tbody = document.getElementById('productsTable');
    tbody.innerHTML='';
    products.forEach(p=>{
        const status = getStockStatus(p.stock);
        const statusClass = status==='Low Stock'?'low-stock':status==='Out of Stock'?'out-stock':'active-stock';
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${p.sku}</td><td>${p.name}</td><td>${p.stock}</td><td>₱${p.price}</td>
                        <td class="${statusClass}">${p.status || status}</td>
                        <td><input type="number" min="0" value="${p.stock}" onblur="updateStock(${p.item_id}, this.value)"></td>`;
        tbody.appendChild(tr);
    });
}

// --- Update Stock (AJAX) ---
function updateStock(stock_id, value){
    const quantity = parseInt(value);
    if(isNaN(quantity) || quantity<0) return;

    fetch('update_stock.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`stock_id=${stock_id}&quantity=${quantity}`
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.status==='success'){
            renderProducts(); // reload table
        } else {
            alert('Failed to update stock');
        }
    });
}


// --- Render Orders ---
function renderOrders(){
    const tbody = document.getElementById('ordersTable');
    tbody.innerHTML='';
    orders.forEach(o=>{
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${o.order_id}</td><td>${o.customer_name}</td><td>${o.product_name}</td><td>${o.item_quantity}</td>
                        <td>₱${o.item_quantity*o.price}</td><td>${o.date_claimed||o.date_ordered}</td><td>${o.order_status}</td>`;
        tbody.appendChild(tr);
    });
}

// --- Render Sales Chart ---
function renderSalesChart(){
    const ctx = document.getElementById('salesChart').getContext('2d');
    const productSales = {};
    orders.forEach(o=>{
        productSales[o.product_name] = (productSales[o.product_name]||0)+parseInt(o.item_quantity);
    });
    new Chart(ctx,{
        type:'bar',
        data:{
            labels: Object.keys(productSales),
            datasets:[{label:'Units Sold', data:Object.values(productSales), backgroundColor:'rgba(246,174,29,0.7)'}]
        },
        options:{responsive:true, plugins:{legend:{display:false}}}
    });
}

// --- Sidebar & Logout ---
function showView(view){
    ['dashboard','customers','products','orders','sales'].forEach(v=>{
        document.getElementById(v).style.display=(v===view)?'block':'none';
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

// --- Initial Load ---
renderDashboard();
</script>
</body>
</html>