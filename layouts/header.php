<?php
// Hide notices and warnings
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

session_start();
// include('../server/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />

  <style>
    .nav-search input {
      width: 220px;
    }

    @media (max-width: 992px) {
      .nav-search input {
        width: 100%;
      }
    }
  </style>




</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
    <div class="container">
      <div class="d-flex w-100 align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <img class="logo me-2" src="assets/imgs/1.png" alt="Logo" style="height:40px;" />
          <span class="brand h4 mb-0">University Stationery Hub</span>
        </div>
        <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse mt-2 mt-lg-0" id="navbarSupportedContent">

        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
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

        <form class="d-flex align-items-center ms-lg-3 my-2 my-lg-0 nav-search" role="search" action="search.php"
          method="get">
          <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Search in site"
            aria-label="Search">
          <button class="btn btn-outline-secondary btn-sm" type="submit">
            <i class="fa fa-search" aria-hidden="true"></i>
          </button>
        </form>








        <div class="d-flex align-items-center ms-lg-3 position-relative">
          <a href="cart.php" class="me-3 position-relative">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <?php if (!empty($_SESSION['cart'])) { ?>
              <span class="cart-quantity"><?php echo count($_SESSION['cart']); ?></span>
            <?php } ?>
          </a>

          <?php if (!empty($_SESSION['logged_in'])): ?>
            <!-- When user login shows My Profile -->
            <a href="my_profile.php" class="login-link">My Profile</a>
          <?php else: ?>
            <!-- When user not login shows Log in -->
            <a href="login.php" class="login-link">Log In</a>
          <?php endif; ?>





        </div>
      </div>
  </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>