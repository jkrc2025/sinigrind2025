<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cart - SiniGrind</title>
<style>
  body { font-family: Arial; background: #e6e2d7; margin:0; padding:0; }
  h1 { text-align:center; margin-top:20px; }
  .back-btn {
    display:block;
    width:120px;
    margin: 10px auto 0 auto;
    padding:8px 12px;
    background:#522d1b;
    color:#fff;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:14px;
    text-align:center;
    text-decoration:none;
  }
  .back-btn:hover { background:#3e1f12; }

  table { width: 80%; margin: 30px auto; border-collapse: collapse; background:#fff; border-radius:10px; overflow:hidden; }
  th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ccc; }
  th { background: #f2ae1d; color: #fff; }
  img { width: 80px; height:80px; object-fit:cover; border-radius:5px; }
  .remove-btn { background: #ff4d4d; color:#fff; border:none; padding:6px 10px; border-radius:5px; cursor:pointer; }
  .checkout { display:block; width:200px; margin:20px auto; padding:12px; background:#f2ae1d; color:#fff; border:none; border-radius:10px; cursor:pointer; font-size:16px; }
  .empty-msg { text-align:center; margin-top:50px; font-size:18px; }
</style>
</head>
<body>

<h1>Your Cart</h1>
<button class="back-btn" onclick="goBack()">← Back to Shop</button>

<table id="cartTable">
  <thead>
    <tr>
      <th>Product</th>
      <th>Name</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Total</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <!-- Cart items will be inserted here -->
  </tbody>
</table>

<button class="checkout" onclick="checkout()">Checkout</button>
<p class="empty-msg" id="emptyMsg"></p>

<script>
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const tbody = document.querySelector('#cartTable tbody');
  const emptyMsg = document.getElementById('emptyMsg');

  function renderCart() {
    tbody.innerHTML = '';
    if(cart.length === 0) {
      emptyMsg.textContent = "Your cart is empty!";
      return;
    }
    emptyMsg.textContent = '';
    cart.forEach((item, index) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td><img src="${item.img}" alt="${item.name}"></td>
        <td>${item.name}</td>
        <td>₱${item.price}</td>
        <td><input type="number" value="${item.qty}" min="1" onchange="updateQty(${index}, this.value)"></td>
        <td>₱${item.price * item.qty}</td>
        <td><button class="remove-btn" onclick="removeItem(${index})">Remove</button></td>
      `;
      tbody.appendChild(tr);
    });
  }

  function updateQty(index, newQty) {
    cart[index].qty = parseInt(newQty);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
  }

  function removeItem(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
  }

  function checkout() {
    alert('wla ka namn inadd to cart sah!');
  }

  function goBack() {
    window.history.back(); 
  }

  renderCart();
</script>

</body>
</html>
