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

    <style>
    .nav-search input{ width:220px; }
    @media (max-width: 992px){ .nav-search input{ width:100%; } }
    </style> 




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

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

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

            <form class="d-flex align-items-center ms-lg-3 my-2 my-lg-0 nav-search" role="search" action="search.php" method="get">
           <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Search in site" aria-label="Search">
           <button class="btn btn-outline-secondary btn-sm" type="submit">
          <i class="fa fa-search" aria-hidden="true"></i>
          </button>
         </form>







 
               <div class="d-flex align-items-center ms-lg-3 position-relative">
              <a href="cart.php" class="me-3 position-relative">
             <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <?php if (!empty($_SESSION['quantity'])) { ?>
              <span class="cart-quantity"><?php echo (int)$_SESSION['quantity']; ?></span>
            <?php } ?>
              </a>
              <!-- Updated: Person icon now links to My Profile -->
              <a href="my_profile.php" title="My Profile">
                <i class="fa fa-user" aria-hidden="true"></i>
              </a>
           
        </div>
      </div>
    </nav>
