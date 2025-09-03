<?php
session_start();
// include('../server/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
      <div class="container">
        <img class="logo" src="assets/imgs/1.png" alt="" />
        <h2 class="brand">University Stationery Hub</h2>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.php">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
            </ul>

             <!-- NEW: Search Bar -->
          <form class="d-flex me-3" action="shop.php" method="POST">
            <input class="form-control me-2" type="search" name="keyword" placeholder="Search products...">
            <button class="btn btn-outline-success" type="submit" name="top_search">Search</button>
          </form>
          <!-- End Search -->

          <ul class="navbar-nav">
            <li class="nav-item d-flex align-items-center">
            
              <a href="cart.php" class="me-3">
                <i class="fa fa-shopping-cart" aria-hidden="true">
                  <?php if (isset($_SESSION['quantity']) && $_SESSION['quantity'] != 0) { ?>
                    <span class="cart-quantity"><?php echo $_SESSION['quantity']; ?></span>
                  <?php } ?>
                </i>
              </a>

              
              <!--NEW: Log In / Log Out -->
              <?php if (isset($_SESSION['user_id'])): ?>
               
                <form action="logout.php" method="POST" class="d-inline">
                  <button type="submit" class="btn btn-danger">Log Out</button>
                </form>
              <?php else: ?>
               
                <a href="login.php" class="btn btn-primary">Log In</a>
              <?php endif; ?>
              <!-- End Log In / Log Out -->

            </li>
          </ul>
        </div>
      </div>
    </nav>
