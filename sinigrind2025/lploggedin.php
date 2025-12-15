<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="lplogged.css" />
  <title>SiniGrind Coffee</title>
</head>
<!-- USER SIDEBAR -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h3>User Menu</h3>
    <span id="closeSidebar">&times;</span>
  </div>

  <ul class="sidebar-links">
    <li><a href="#">My Profile</a></li>
    <li><a href="cart.php">Cart</a></li>
    <li><a href="historyorder.php">Order History</a></li>
    <li><a href="index.php">Logout</a></li>

  </ul>
</div>

<div class="overlay" id="overlay"></div>

<body>
  <header class="navbar">
    <div class="logo">
      <img src="logo_iconpeanutbutter.png" alt="SiniGrind Logo" />
    </div>
    <nav class="nav-links">
      <a href="#hero">Home</a>
      <a href="bproduct.php">Coffee Products</a>
      <a href="#about-us">About Us</a>
      <a href="#testimonials">Testimonials</a>
      <a href="#contact-info">Contact</a>
    </nav>
   <div class="auth-buttons">
  <button class="profile-btn" id="profileBtn">☰ Profile</button>
</div>
  </header>

  <section id="hero" class="hero">
    <div class="hero-text">
      <h1>Best Coffee</h1>
      <p class="subtitle">Make your day great with our special coffee!</p>
      <p>Welcome to our coffee paradise, where every bean tells a story and every cup sparks joy.</p>
      <div class="hero-buttons">
        <a href="bproduct.php"><button class="order">Order Now</button></a>
        <a href="#contact-info"><button class="contact">Contact Us</button></a>
      </div>
    </div>
  </section>

  <section id="about-us" class="about-us">
    <h2>ABOUT US</h2>
    <hr />
    <p>
      SiniGrind prides itself in serving exceptional coffee quality, the go-to for coffee lovers and caffeine addicts alike. We’re dedicated to providing only the best coffee and comfort, like home.
    </p>
  </section>

  <section id="coffee-products" class="coffee-products">
    <h2>BEST SELLER COFFEE</h2>
    <hr />
     <div class="coffee-card">
      <img src="assets/coffeepack1.png" alt="Arabica Coffee">
      <h3>Arabica Coffee</h3>
      <p>100% Arabica beans—smooth, aromatic, and bold.</p>
    </div>

    <div class="coffee-card">
      <img src="assets/coffeepack2.png" alt="Pink Coffee">
      <h3>Pink Coffee</h3>
      <p>Unique, flavorful, and unapologetically fun.</p>
    </div>

    <div class="coffee-card">
      <img src="assets/coffeepack4.png" alt="Matcha Coffee">
      <h3>Matcha Coffee</h3>
      <p>Earthy matcha blended with rich coffee notes.</p>
    </div>

    <div class="coffee-card">
      <img src="assets/coffeepack2.png" alt="Black Coffee">
      <h3>Black Coffee</h3>
      <p>Pure, intense, deeply roasted perfection.</p>
    </div>
    </div>
  </section>

  <section id="testimonials" class="testimonials">
    <h2>TESTIMONIALS</h2>
    <hr />
    <div class="carousel">
      <div class="testimonial active">
        <h4>Emilio Aguinaldo</h4>
        <p>"I was skeptical at first because it's a bit pricey but then it is worth buying, such a good coffee."</p>
      </div>
      <div class="testimonial">
        <h4>Mark Zuckerberg</h4>
        <p>"Thank you for blessing us with such a quality product, will buy again."</p>
      </div>
      <div class="testimonial">
        <h4>Liza Soberano</h4>
        <p>"This is now my favorite coffee, so delish!"</p>
      </div>
      <div class="testimonial">
        <h4>Hayoko Napo</h4>
        <p>"I was recommended to try this brand while exploring my drink preference, definitely worth buying."</p>
      </div>
      <div class="testimonial">
        <h4>Tamana Poe</h4>
        <p>"This tastes just as how I always wanted my coffee, will definitely buy again."</p>
      </div>
    </div>
  </section>

  <footer id="contact-info" class="contact-info">
    <p>0123 Centro Occidental, Polangui, 4506 Albay, Philippines</p>
    <p>sinigrindcoffee@gmail.com</p>
    <p>(+63) 912-345-6789</p>
    <p>Monday - Saturday: 9:00 AM - 5:00 PM | Sunday: Closed</p>
    <p>www.sinigrindcoffee.com</p>
  </footer>
 <script>
    // SIDEBAR JS
    const profileBtn = document.getElementById("profileBtn");
    const sidebar = document.getElementById("sidebar");
    const closeSidebar = document.getElementById("closeSidebar");
    const overlay = document.getElementById("overlay");

    profileBtn.addEventListener("click", () => {
      sidebar.classList.add("active");
      overlay.classList.add("active");
    });

    closeSidebar.addEventListener("click", () => {
      sidebar.classList.remove("active");
      overlay.classList.remove("active");
    });

    overlay.addEventListener("click", () => {
      sidebar.classList.remove("active");
      overlay.classList.remove("active");
    });
  </script>
</body>
</html>