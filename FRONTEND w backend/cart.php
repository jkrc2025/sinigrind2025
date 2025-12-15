<?php
session_start();

$conn = new mysqli("localhost", "root", "", "sinigrind_db");
if ($conn->connect_error) die("DB error");

if (!isset($_SESSION['user_id'])) {
    die("Please login first");
}

$user_id = $_SESSION['user_id'];

// FETCH CART ITEMS
$sql = "
SELECT 
  o.order_id,
  o.item_quantity,
  p.name,
  p.price,
  p.image_file
FROM orders o
JOIN products p ON o.item_id = p.item_id
WHERE o.user_id = ? AND o.order_status = 'cart'
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cartItems = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cart - SiniGrind</title>
<style>
  body { font-family: Arial; background:#e6e2d7; margin:0; }
  h1 { text-align:center; margin-top:20px; }
  .back-btn {
    display:block; width:120px; margin:10px auto;
    padding:8px; background:#522d1b; color:#fff;
    border:none; border-radius:8px; cursor:pointer;
  }
  table {
    width:80%; margin:30px auto; border-collapse:collapse;
    background:#fff; border-radius:10px; overflow:hidden;
  }
  th, td { padding:12px; text-align:center; border-bottom:1px solid #ccc; }
  th { background:#f2ae1d; color:#fff; }
  img { width:80px; height:80px; border-radius:5px; object-fit:cover; }
  .remove-btn { background:#ff4d4d; color:#fff; border:none; padding:6px 10px; border-radius:5px; }
  .checkout { display:block; width:200px; margin:20px auto; padding:12px;
    background:#f2ae1d; color:#fff; border:none; border-radius:10px; }
  .empty-msg { text-align:center; margin-top:50px; font-size:18px; }
</style>
</head>
<body>

<h1>Your Cart</h1>
<button class="back-btn" onclick="history.back()">← Back to Shop</button>

<?php if ($cartItems->num_rows === 0): ?>
  <p class="empty-msg">Your cart is empty!</p>
<?php else: ?>
<table>
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

<?php while ($row = $cartItems->fetch_assoc()): ?>
<tr>
  <td><img src="<?= $row['image_file'] ?>"></td>
  <td><?= $row['name'] ?></td>
  <td>₱<?= $row['price'] ?></td>
  <td>
    <form method="post" action="update_cart.php">
      <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
      <input type="number" name="quantity" value="<?= $row['item_quantity'] ?>" min="1">
      <button type="submit">Update</button>
    </form>
  </td>
  <td>₱<?= $row['price'] * $row['item_quantity'] ?></td>
  <td>
    <form method="post" action="remove_cart.php">
      <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
      <button class="remove-btn">Remove</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>

</tbody>
</table>

<button class="checkout">Checkout</button>
<?php endif; ?>

</body>
</html>