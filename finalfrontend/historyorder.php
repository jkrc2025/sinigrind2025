<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order History - SiniGrind</title>

<a href="lploggedin.php" class="home-button">Home</a>

<style>
  body { font-family: Arial, sans-serif; background: #a0663c; color: #fff; }
  .history-order { max-width: 1200px; margin: 100px auto; }
  .order-section { background: #522d1b; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
  .order-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f2ae1d; }
  .order-row:last-child { border-bottom: none; }
  .order-message { margin-top: 10px; font-size: 14px; }
  .no-orders { text-align: center; font-size: 18px; padding: 50px; background: rgba(0,0,0,0.2); border-radius: 10px; }

  .home-button {
  display: inline-block;
  padding: 8px 16px;
  background-color: #f2ae1d; /* matches your theme */
  color: #fff;
  font-family: "NanumGothic-Bold", Helvetica;
  font-weight: 700;
  text-decoration: none;
  border-radius: 8px;
  margin-left: 50px; /* or wherever it fits your layout */
}

.home-button:hover {
  background-color: #e59c1a;
}

</style>
</head>
<body>

<div class="history-order">
  <h1>Order History</h1>
  <div id="ordersContainer"></div>
</div>

<script>
  // MOCK USER ORDERS
  const orders = [
    {
      id: 1046,
      date: '2025-12-15',
      status: 'Processing Order',
      statusClass: 'status-processing',
      products: ['Arabica Coffee', 'Matcha Coffee', 'White Coffee'],
      quantity: 13,
      price: 5025,
      pickupDate: '2025-12-18'
    },
    {
      id: 1045,
      date: '2025-10-15',
      status: 'Completed',
      statusClass: 'status-completed',
      products: ['Matcha Coffee'],
      quantity: 3,
      price: 1245,
      pickupDate: '2025-10-18'
    }
  ];

  const ordersContainer = document.getElementById('ordersContainer');

  if(orders.length === 0){
    ordersContainer.innerHTML = '<div class="no-orders">No orders yet</div>';
  } else {
    orders.forEach(order => {
      const orderHTML = `
        <section class="order-section">
          <div class="order-row">
            <div>Order #${order.id}</div>
            <div>Ordered On: ${new Date(order.date).toDateString()}</div>
            <div class="${order.statusClass}">${order.status}</div>
            <div>Products: ${order.products.join(', ')}</div>
            <div>Quantity: ${order.quantity}</div>
            <div>Price: ₱${order.price.toLocaleString()}</div>
          </div>
          <div class="order-message">
            Your order is ${order.status.toLowerCase()} for pick-up on ${new Date(order.pickupDate).toDateString()}.
          </div>
        </section>
      `;
      ordersContainer.innerHTML += orderHTML;
    });
  }
</script>

</body>
</html>
