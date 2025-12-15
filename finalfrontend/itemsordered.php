<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - SiniGrind</title>
<style>
/* Reset */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "NanumGothic-Regular", Helvetica, sans-serif;
}

body {
  background-color: #a0663c;
  color: #fff;
  min-height: 100vh;
  padding: 0 40px;
}

/* Header */
.checkout-header {
  padding: 40px 0 20px 0;
}

.checkout-header h1 {
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 10px;
}

.breadcrumb a {
  color: #fff;
  text-decoration: none;
  margin-right: 5px;
}

.breadcrumb a:hover {
  text-decoration: underline;
}

.breadcrumb span {
  font-weight: bold;
}

/* Layout */
.checkout-main {
  display: flex;
  gap: 40px;
  margin-top: 20px;
}

/* Order Summary */
.order-summary {
  background-color: #f2ae1d;
  padding: 20px;
  border-radius: 12px;
  flex: 1;
  color: #522d1b;
}

.order-summary h2 {
  font-weight: 700;
  margin-bottom: 20px;
}

.checkout-item {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
  font-size: 16px;
}

.checkout-totals {
  margin-top: 20px;
  font-weight: bold;
  font-size: 16px;
  display: flex;
  flex-direction: column;
  gap: 5px;
}

/* Payment */
.checkout-payment {
  background-color: #f2ae1d;
  padding: 20px;
  border-radius: 12px;
  flex: 1;
  color: #522d1b;
}

.checkout-payment h2 {
  font-weight: 700;
  margin-bottom: 20px;
}

.payment-method label {
  display: block;
  margin-bottom: 12px;
  cursor: pointer;
}

.pickup-date {
  margin-bottom: 20px;
}

.confirm-order {
  margin-top: 20px;
  background-color: #522d1b;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 14px;
  font-size: 16px;
  cursor: pointer;
  width: 100%;
  transition: background 0.3s;
}

.confirm-order:hover {
  background-color: #3e1f12;
}

/* Footer */
.checkout-footer {
  margin-top: 60px;
  display: flex;
  justify-content: space-between;
  color: #522d1b;
}

.checkout-footer a {
  color: #522d1b;
  text-decoration: none;
}

.checkout-footer a:hover {
  text-decoration: underline;
}
</style>
</head>
<body>

<div class="checkout-page">

  <!-- Header -->
  <header class="checkout-header">
    <h1>Checkout</h1>
    <nav class="breadcrumb">
      <a href="lploggedin.php">Home</a> / <a href="cart.php">Cart</a> / <span>Checkout</span>
    </nav>
  </header>

  <!-- Main -->
  <main class="checkout-main">

    <!-- Order Summary -->
    <section class="order-summary">
      <h2>Order Summary</h2>
      <div class="checkout-items">
        <div class="checkout-item" data-price="450" data-qty="5">
          <span class="item-name">Arabica Coffee x<span class="qty">5</span></span>
          <span class="item-price">₱<span class="price">2250</span></span>
        </div>
        <div class="checkout-item" data-price="415" data-qty="5">
          <span class="item-name">Matcha Coffee x<span class="qty">5</span></span>
          <span class="item-price">₱<span class="price">2075</span></span>
        </div>
        <div class="checkout-item" data-price="449" data-qty="3">
          <span class="item-name">White Coffee x<span class="qty">3</span></span>
          <span class="item-price">₱<span class="price">1347</span></span>
        </div>
      </div>
      <div class="checkout-totals">
        <div class="subtotal">Subtotal: ₱<span id="subtotal">5622</span></div>
        <div class="estimated-total">Estimated Total: ₱<span id="total">5622</span></div>
      </div>
    </section>

    <!-- Pickup & Payment -->
    <section class="checkout-payment">
      <h2>Pickup & Payment</h2>
      <div class="pickup-date">
        <span>Pickup Available:</span>
        <time datetime="2025-12-18">Dec 18, 2025</time>
      </div>

      <div class="payment-method">
        <h3>Select Payment Method:</h3>
        <label>
          <input type="radio" name="payment" checked> Cash on Pickup
        </label>
      </div>

      <button class="confirm-order" onclick="confirmOrder()">Confirm Order</button>
    </section>

  </main>

  <!-- Footer -->
  <footer class="checkout-footer">
    <p>© DataLadder 2025 SiniGrind. All Rights Reserved.</p>
    <p><a href="#terms">User Terms & Conditions</a> | <a href="#privacy">Privacy Policy</a></p>
  </footer>

</div>

<script>
// JS for updating totals dynamically
function updateTotals() {
  const items = document.querySelectorAll('.checkout-item');
  let subtotal = 0;
  items.forEach(item => {
    const price = parseInt(item.dataset.price);
    const qty = parseInt(item.dataset.qty);
    subtotal += price * qty;
  });
  document.getElementById('subtotal').textContent = subtotal;
  document.getElementById('total').textContent = subtotal;
}

// Call it initially
updateTotals();

// Confirm order alert
function confirmOrder() {
  alert("Your order has been confirmed! Total: ₱" + document.getElementById('total').textContent);
}
</script>

</body>
</html>
