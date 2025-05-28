<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>University Stationery Hub</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f9f9f9;
    }

    header {
      background: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 40px;
      border-bottom: 1px solid #ccc;
    }

    .logo {
      font-weight: bold;
      font-size: 22px;
    }

    nav a {
      margin: 0 15px;
      text-decoration: none;
      color: black;
    }

    .hero {
      background-color: #ff6a00;
      color: white;
      text-align: center;
      padding: 40px 20px;
    }

    .hero button {
      padding: 10px 20px;
      background: black;
      color: white;
      border: none;
      font-size: 16px;
      margin-top: 10px;
      cursor: pointer;
    }

    section {
      padding: 40px;
      background: white;
    }

    .products, .features {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .product-card, .feature-card {
      background: #fff;
      border: 1px solid #ccc;
      padding: 15px;
      width: 200px;
      text-align: center;
      border-radius: 6px;
    }

    .product-card img, .feature-card img {
      width: 100%;
      height: 160px;
      object-fit: contain;
      margin-bottom: 10px;
    }

    .newsletter {
      display: flex;
      justify-content: space-between;
      padding: 40px;
      background: #f2f2f2;
    }

    .newsletter input {
      padding: 8px;
      margin-bottom: 10px;
      width: 250px;
    }

    .newsletter button {
      padding: 8px 20px;
      background: black;
      color: white;
      border: none;
    }

    footer {
      text-align: center;
      padding: 20px;
      font-size: 14px;
      background: white;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">University Stationery Hub</div>
  <nav>
    <a href="#">Home</a>
    <a href="#">Products</a>
    <a href="#">Contact Us</a>
    <input type="text" placeholder="Search in site">
    <button>Log In</button>
  </nav>
</header>

<div class="hero">
  <h1>Welcome to University Stationery Hub!</h1>
  <p>Find all your stationery needs in one place.</p>
  <button>Shop Now</button>
</div>

<section>
  <h2>Popular Products</h2>
  <div class="products">
    <div class="product-card">
      <img src="Notebook.jpg" alt="Notebook">
      <p><strong>Classic Notebook</strong><br>Price: $5.66</p>
    </div>
    <div class="product-card">
      <img src="Gel pen set.jpg" alt="Gel Pen Set">
      <p><strong>Gel Pen Set</strong><br>Price: $2.00</p>
    </div>
    <div class="product-card">
      <img src="Pencil.jpg" alt="HB Pencil">
      <p><strong>HB Pencil with Eraser Tip</strong><br>Price: $3.00</p>
    </div>
  </div>
</section>

<section>
  <h2>Featured Items</h2>
  <div class="features">
    <div class="feature-card">
      <img src="sketchbook.jpg" alt="Sketchbook">
      <p><strong>Sketchbook</strong><br>Price: $14.99</p>
    </div>
    <div class="feature-card">
      <img src="binder clips.jpg" alt="Binder Clips">
      <p><strong>Binder Clips</strong><br>Price: $2.49</p>
    </div>
    <div class="feature-card">
      <img src="highlighters.jpg" alt="Highlighters">
      <p><strong>Highlighters</strong><br>Price: $7.99</p>
    </div>
  </div>
</section>

<section class="newsletter">
  <div>
    <h3>Subscribe to Our Newsletter</h3>
    <p>Stay updated with our latest offers and promotions</p>
  </div>
  <form>
    <input type="email" placeholder="Enter your email"><br>
    <input type="text" placeholder="Enter your name"><br>
    <button type="submit">Subscribe</button>
  </form>
</section>

<footer>
  © 2023 AUT Stationery Hub. All Rights Reserved. |
  <a href="#">Privacy Policy</a> |
  <a href="#">Terms & Conditions</a>
</footer>

</body>
</html>
