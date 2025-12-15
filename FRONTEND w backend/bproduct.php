<?php
session_start();

// DB CONNECTION
$conn = new mysqli("localhost", "root", "", "sinigrind_db");
if ($conn->connect_error) {
    die("Database connection failed");
}

// FETCH PRODUCTS
$products = [];
$res = $conn->query("SELECT item_id, name, description, price, image_file FROM products");
while ($row = $res->fetch_assoc()) {
    $products[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SiniGrind Products</title>

<style>
body { margin:0; font-family: Arial; background:#e6e2d7; }
.navbar { display:flex; justify-content:space-between; background:#fff; padding:12px 30px; }
.navbar a { margin:0 15px; text-decoration:none; color:#000; }
.coffees { display:flex; flex-wrap:wrap; gap:25px; padding:40px; justify-content:center; }
.coffee-card {
  background:#fff; width:240px; padding:15px; border-radius:10px;
  box-shadow:0 3px 6px rgba(0,0,0,0.1); cursor:pointer;
}
.coffee-card img { width:100%; height:150px; border-radius:10px; object-fit:cover; }
.coffee-card h3 { margin:10px 0 5px; }
.coffee-card .price { color:#f2ae1d; font-weight:bold; }

.aside-product {
  position:fixed; top:80px; right:20px; width:300px;
  background:#fff; padding:20px; border-radius:10px;
  box-shadow:0 5px 10px rgba(0,0,0,0.15); display:none;
}
.aside-product img { width:100%; height:200px; border-radius:10px; object-fit:cover; }
.aside-product button {
  width:100%; padding:10px; border:none; border-radius:8px;
  background:#f2ae1d; color:#fff; font-weight:bold; cursor:pointer;
}
</style>
</head>

<body>

<header class="navbar">
  <div>
    <a href="#">Home</a>
    <a href="#" style="color:#a0663c;">Products</a>
  </div>
</header>

<main class="coffees">
<?php foreach ($products as $p): ?>
  <div class="coffee-card"
    data-id="<?= $p['item_id'] ?>"
    data-name="<?= htmlspecialchars($p['name']) ?>"
    data-desc="<?= htmlspecialchars($p['description']) ?>"
    data-price="<?= $p['price'] ?>"
    data-img="<?= $p['image_file'] ?>">
    <img src="<?= $p['image_file'] ?>">
    <h3><?= $p['name'] ?></h3>
    <p><?= $p['description'] ?></p>
    <div class="price">₱<?= $p['price'] ?></div>
  </div>
<?php endforeach; ?>
</main>

<aside class="aside-product" id="productAside">
<form method="post" action="cart.php">
  <img id="asideImg">
  <h3 id="asideName"></h3>
  <p id="asideDesc"></p>
  <div class="price" id="asidePrice"></div>

  <input type="hidden" name="item_id" id="asideItemId">

  <label>Quantity:
    <input type="number" name="quantity" value="1" min="1" required>
  </label>

  <button type="submit">Add to Cart</button>
</form>
</aside>

<script>
const cards = document.querySelectorAll(".coffee-card");
const aside = document.getElementById("productAside");

cards.forEach(card => {
  card.onclick = () => {
    aside.style.display = "block";
    document.getElementById("asideImg").src = card.dataset.img;
    document.getElementById("asideName").innerText = card.dataset.name;
    document.getElementById("asideDesc").innerText = card.dataset.desc;
    document.getElementById("asidePrice").innerText = "₱" + card.dataset.price;
    document.getElementById("asideItemId").value = card.dataset.id;
  };
});
</script>

</body>
</html>
