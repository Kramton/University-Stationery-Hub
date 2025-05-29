<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>University Stationery Hub - Product Page</title>
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

    .product-container {
      display: flex;
      max-width: 900px;
      margin: 40px auto;
    }

    .product-image {
      flex: 1;
    }

    .product-image img {
      width: 100%;
      max-width: 400px;
    }

    .product-details {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .product-details p.price {
      font-size: 22px;
      font-weight: bold;
    }

    .product-details button {
      width: 150px;
      padding: 12px;
      background: #ff6a00;
      border: none;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }

    footer {
      text-align: center;
      padding: 20px;
      font-size: 14px;
      background: white;
      margin-top: 60px;
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
    <input type="text" placeholder="Search in site" />
    <button>Log In</button>
  </nav>
</header>

<div class="product-container">
  <div class="product-image">
    <img src="Notebook.jpg" alt="Classic Notebook" />
  </div>
  <div class="product-details">
    <h1>Classic Notebook</h1>
    <p class="description">
      Classic everyday notebook for university students. Contains 100 lined pages.
    </p>
    <p class="price">$5.66</p>
    <button>Add to Cart</button>
  </div>
</div>

<footer>
  © University Stationary Hub. All Rights Reserved. |
  <a href="#">Privacy Policy</a> |
  <a href="#">Terms & Conditions</a>
</footer>

</body>
</html>
