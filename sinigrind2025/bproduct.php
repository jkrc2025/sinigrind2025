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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SiniGrind - Coffee Products</title>
  <style>
    /* SIMPLE GLOBAL RESET & STYLES */
    body {
      font-family: Arial, sans-serif;
      background: #e6e2d7;
      margin: 0;
      padding: 0;
    }
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #fff;
      padding: 12px 30px;
      border-bottom: 1px solid #ccc;
    }
    .navbar .logo { height: 40px; }
    .navbar nav a { margin: 0 15px; text-decoration: none; color: #000; font-weight: 500; }
    .search-bar input {
      padding: 6px 10px;
      border-radius: 20px;
      border: 1px solid #ccc;
      width: 200px;
    }
    main.coffees {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      padding: 40px;
      justify-content: center;
    }
    .coffee-card {
      background: #fff;
      width: 240px;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
      cursor: pointer;
      transition: transform 0.2s ease;
    }
    .coffee-card:hover { transform: translateY(-5px); }
    .coffee-card img {
      width: 100%;
      height: 150px;
      border-radius: 10px;
      object-fit: cover;
      background: #f2ae1d;
    }
    .coffee-card h3 { margin: 10px 0 5px; font-size: 18px; }
    .coffee-card p { font-size: 14px; color: #444; }
    .coffee-card .price { font-weight: bold; color: #f2ae1d; margin-top: 5px; }

    .aside-product {
      position: fixed;
      top: 80px;
      right: 20px;
      width: 300px;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 5px 10px rgba(0,0,0,0.15);
      display: none;
    }
    .aside-product img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    .aside-product h3 { margin-top: 10px; }
    .aside-product .price { color: #f2ae1d; font-weight: bold; margin-top: 8px; }
    .aside-product input { width: 50px; padding: 5px;}

    .aside-product button {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: none;
      margin-top: 8px;
      font-weight: bold;
      cursor: pointer;
    }
    .order-btn { background: #f2ae1d; color: #fff; }
    .buy-btn { background: #fff; color: #f2ae1d; border: 1px solid #f2ae1d; }

    footer {
      text-align: center;
      padding: 15px;
      background: #f2ae1d;
      color: #522d1b;
      margin-top: 40px;
    }
  </style>
</head>
<body>

  <header class="navbar">
    <img src="logo_iconpeanutbutter.png" class="logo" alt="SiniGrind Logo" />
    <nav>
      <a href="lploggedin.php">Home</a>
      <a href="#" style="color:#a0663c;">Coffee Products</a>
      <a href="#">About</a>
      <a href="#">Testimonials</a>
      <a href="#">Contact</a>
    </nav>
    <div class="search-bar">
      <input type="search" id="searchInput" placeholder="Search products...">
    </div>
  </header>

  <main class="coffees">
    <!-- 8 Products -->
    <div class="coffee-card" data-name="Arabica Coffee" data-price="450" data-desc="100% from Arabica beans — smooth, aromatic, bold." data-img="img/arabica.png">
      <img src="assets/coffeepack1.png" alt="Arabica Coffee">
      <h3>Arabica Coffee</h3>
      <p>100% Arabica beans — smooth, aromatic, bold.</p>
      <div class="price">₱450</div>
    </div>

    <div class="coffee-card" data-name="Colombia Coffee" data-price="450" data-desc="Authentic Arabica beans from Colombia — fresh, strong." data-img="img/colombia.png">
      <img src="assets/coffeepack2.png" alt="Colombia Coffee">
      <h3>Colombia Coffee</h3>
      <p>Authentic Arabica beans from Colombia — fresh, strong.</p>
      <div class="price">₱450</div>
    </div>

    <div class="coffee-card" data-name="Pink Coffee" data-price="485" data-desc="Unique, flavorful, unapologetically fun." data-img="img/pink.png">
      <img src="assets/coffeepack3.png" alt="Pink Coffee">
      <h3>Pink Coffee</h3>
      <p>Unique, flavorful, unapologetically fun.</p>
      <div class="price">₱485</div>
    </div>

    <div class="coffee-card" data-name="Matcha Coffee" data-price="415" data-desc="Earthy matcha blended with rich coffee notes." data-img="img/matcha.png">
      <img src="assets/coffeepack4.png" alt="Matcha Coffee">
      <h3>Matcha Coffee</h3>
      <p>Earthy matcha blended with rich coffee notes.</p>
      <div class="price">₱415</div>
    </div>

    <div class="coffee-card" data-name="Blue Coffee" data-price="389" data-desc="Ground blue coffee from Iceland — icy, cool." data-img="img/blue.png">
      <img src="assets/coffeepack5.png" alt="Blue Coffee">
      <h3>Blue Coffee</h3>
      <p>Ground blue coffee from Iceland — icy, cool.</p>
      <div class="price">₱389</div>
    </div>

    <div class="coffee-card" data-name="Yellow Coffee" data-price="399" data-desc="Yellow coffee made near the ocean — fresh, salty." data-img="img/yellow.png">
      <img src="assets/coffeepack6.png" alt="Yellow Coffee">
      <h3>Yellow Coffee</h3>
      <p>Yellow coffee made near the ocean — fresh, salty.</p>
      <div class="price">₱399</div>
    </div>

    <div class="coffee-card" data-name="Black Coffee" data-price="459" data-desc="Pure and bold brew — intense, strong." data-img="img/black.png">
      <img src="assets/coffeepack2.png" alt="Black Coffee">
      <h3>Black Coffee</h3>
      <p>Pure and bold brew — intense, strong.</p>
      <div class="price">₱459</div>
    </div>

    <div class="coffee-card" data-name="White Coffee" data-price="449" data-desc="Smooth, creamy blend — mild, rich." data-img="img/white.png">
      <img src="assets/coffeepack5.png" alt="White Coffee">
      <h3>White Coffee</h3>
      <p>Smooth, creamy blend — mild, rich.</p>
      <div class="price">₱449</div>
    </div>
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

  <footer>
    © 2025 SiniGrind Coffee. All Rights Reserved | User Terms & Conditions | Privacy Policy
  </footer>

  <script>
    const cards = document.querySelectorAll(".coffee-card");
    const aside = document.getElementById("productAside");
    const asideImg = document.getElementById("asideImg");
    const asideName = document.getElementById("asideName");
    const asideDesc = document.getElementById("asideDesc");
    const asidePrice = document.getElementById("asidePrice");

    cards.forEach(card => {
      card.addEventListener("click", () => {
        aside.style.display = "block";
        asideImg.src = card.dataset.img;
        asideName.textContent = card.dataset.name;
        asideDesc.textContent = card.dataset.desc;
        asidePrice.textContent = `₱${card.dataset.price}`;
      });
    });

    const searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("input", e => {
      const term = e.target.value.toLowerCase();
      cards.forEach(card => {
        const name = card.dataset.name.toLowerCase();
        card.style.display = name.includes(term) ? "block" : "none";
      });
    });
    
    function openAside(product) {
  document.getElementById('asideImg').src = 
    'assets/images/' + product.image;

  document.getElementById('asideName').textContent = product.name;
  document.getElementById('asideDesc').textContent = product.description;
  document.getElementById('asidePrice').textContent = '₱' + product.price;
  document.getElementById('asideItemId').value = product.id;

  document.getElementById('productAside').style.display = 'block';
}
  </script>
  
</body>
</html>
