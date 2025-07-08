<?php 

include('server/connection.php');

$stmt = $conn->prepare("SELECT * FROM products");

$stmt->execute();

$products = $stmt->get_result(); 

?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shop</title>
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
      .product img {
        width: 100%;
        height: auto;
        box-sizing: border-box;
        object-fit: cover;
      }

      .pagination a {
        color: coral;
      }

      .pagination li:hover a {
        color: white;
        background-color: coral;
      }
    </style>
  </head>
  <body>
    <!-- Navbar: py-3 is equal to padding: 3, fixed-top makes the navbar fixed -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
      <div class="container">
        <img class="logo" src="assets/imgs/1.png" alt="" />
        <h2 class="brand">University Stationary Hub</h2>
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
        <div
          class="collapse navbar-collapse nav-buttons"
          id="navbarSupportedContent"
        >
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.html">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li>
            <li class="nav-item">
              <a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
              <a href="account.php"><i class="fa fa-user" aria-hidden="true"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Search -->
    <!-- Featured -->
    <section id="search" class="my-5 py-5 ms-2">
      <div class="container mt-5 py-5">
        <p>Search Product</p>
        <hr>
      </div>

      <form>
        <div class="row mx-auto container">
          <div class="col-lg-12 col-md-12 col-sm-12">


            <p>Category</p>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category_one">
                <label class="form-check-label" for="flexRadioDefault1">
                  Test
                </label> 
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category_two">
                <label class="form-check-label" for="flexRadioDefault2">
                  Test2
                </label> 
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category_two">
                <label class="form-check-label" for="flexRadioDefault2">
                  Test3
                </label> 
              </div>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="category" id="category_two">
                <label class="form-check-label" for="flexRadioDefault2">
                  Test4
                </label> 
              </div>
          </div>
        </div>

        <div class="row mx-auto container mt-5">
           <div class="col-lg-12 col-md-12 col-sm-12">
            <p>Price</p>
            <input type="range" class="form-range w-50" min="1" max="1000" id="customRange2">
            <div class="w-50">
              <span style="float:left;">1</span>
              <span style="float:right;">1000</span>
            </div>
          </div>
        </div>

        <div class="form-group my-3 mx-3">
          <input type="submit" name="search" value="Search" class="btn btn-primary">
        </div>

      </form>

    </section>
     

    <!-- Products -->
    <section id="featured" class="my-5 py-5">
      <div class="container text-center mt-5 py-5">
        <h3>Our Products</h3>
        <hr class="mx-auto"/>
        <p>Here you can check out our products</p>
      </div>

      <?php while($row = $products->fetch_assoc()){ ?>


      <div class="row mx-auto container">
        <div class="product text-center col-lg-3 col-md-4 col-sm-12" onclick="window.location.href='single_product.html'">
          <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" alt="" />

          <div class="star">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>

          <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
          <h4 class="p-price">$<?php echo $row['product_price']; ?></h4>
          <a class="btn shop-buy-btn" href="<?php echo "singe_product.php?product_id=".$row['product_id']; ?>">Buy Now</a>
        </div>
      </div>

      <?php } ?>




        <nav aria-label="Page navigation example">
          <ul class="pagination mt-5 justify-content-center">
            <li class="page-item">
              <a class="page-link" href="#">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
        </nav>
      </div>
    </section>

    <!-- Footer -->
    <footer class="mt-5 py-5">
      <div class="row container mx-auto pt-5">
        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
          <img class="logo" src="assets/imgs/1.png" alt="" />
          <p class="pt-3">
            We provide the best products for the most affordable prices
          </p>
        </div>

        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
          <h5 class="pb-2">Featured</h5>
          <ul class="text-uppercase">
            <li><a href="">men</a></li>
            <li><a href="">women</a></li>
            <li><a href="">new arrivals</a></li>
          </ul>
        </div>

        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
          <h5 class="pb-2">Contact Us</h5>
          <div>
            <h6 class="text-uppercase">Address</h6>
            <p>123 Street Name, City</p>
          </div>
          <div>
            <h6 class="text-uppercase">Phone</h6>
            <p>1234567890</p>
          </div>
          <div>
            <h6 class="text-uppercase">Email</h6>
            <p>info@mail.com</p>
          </div>
        </div>

        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
          <h5 class="pb-2">Instagram</h5>
          <div class="row">
            <img
              src="assets/imgs/1.png"
              class="img-fluid w-25 h-100 m-2"
              alt=""
            />
            <img
              src="assets/imgs/1.png"
              class="img-fluid w-25 h-100 m-2"
              alt=""
            />
            <img
              src="assets/imgs/1.png"
              class="img-fluid w-25 h-100 m-2"
              alt=""
            />
            <img
              src="assets/imgs/1.png"
              class="img-fluid w-25 h-100 m-2"
              alt=""
            />
            <img
              src="assets/imgs/1.png"
              class="img-fluid w-25 h-100 m-2"
              alt=""
            />
          </div>
        </div>
      </div>

      <div class="copyright mt-5">
        <div class="row container mx-auto">
          <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <img src="assets/imgs/1.png" alt="" />
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12 mb-4 mb-2">
            <p>University Stationary Hub © 2025 All Right Reserved</p>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <a href=""><i class="fa fa-facebook"></i></a>
            <a href=""><i class="fa fa-instagram"></i></a>
            <a href=""><i class="fa fa-twitter"></i></a>
          </div>
        </div>
      </div>
    </footer>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
