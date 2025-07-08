<?php

session_start();
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
  header('location: login.php');
  exit;
}

if(isset($_GET['logout'])){
  if(isset($_SESSION['logged_in'])){
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    header('location: login.php');
    exit;
  }
}

if(isset($_POST['change_password'])){
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];
  $user_email = $_SESSION['user_email'];

  // Check both passwords match
  if($password !== $confirmPassword) {
    header('location: account.php?error=Passwords do not match');
  }
  // Check password length is greater than 6
  else if(strlen($password) < 6) {
    header('location: account.php?error=Password must be at least 6 characters');
  
  // no errors
  }else{
    $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
    $stmt->bind_param('ss', md5($password), $user_email);

    if($stmt->execute()){
      header('location: account.php?message=password has been updated successfully');
    }else{
      header('location: account.php?error=could not update password'); 
    }
  }

}

// get orders
if(isset($_SESSION['logged_in'])){

  $user_id = $_SESSION['user_id'];
  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=?");

  $stmt->bind_param('i', $user_id);

  $stmt->execute();

  $orders = $stmt->get_result(); 
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
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

    <!-- Account -->
    <section class="my-5 py-5">
      <div class="row container mx-auto">
        <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
          <p class="text-center" style="color:green"><?php if(isset($_GET['register_success'])){echo $_GET['register_success'];} ?></p>
          <p class="text-center" style="color:green"><?php if(isset($_GET['login_success'])){echo $_GET['login_success'];} ?></p>
          <h3 class="font-weight-bold">Account info</h3>
          <hr class="mx-auto" />
          <div class="account-info">
            <p>Name <span><?php if(isset($_SESSION['user_name'])) 
              {echo $_SESSION['user_name'];} ?></span></p>
            <p>Email <span><?php if(isset($_SESSION['user_email'])) 
              {echo $_SESSION['user_email'];} ?></span></p>
            <p><a href="#orders" id="orders-btn">Your Orders</a></p>
            <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
          </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
          <form id="account-form" method="POST" action="account.php">
            <p class="text-center" style="color:red"><?php if(isset($_GET['error'])){echo $_GET['error'];} ?></p>
            <p class="text-center" style="color:green"><?php if(isset($_GET['message'])){echo $_GET['message'];} ?></p>
            <h3>Change Password</h3>
            <hr class="mx-auto" />
            <div class="form-group">
              <label for="">Password</label>
              <input
                type="password"
                class="form-control"
                id="account-password"
                name="password"
                placeholder="Password"
                required
              />
            </div>
            <div class="form-group">
              <label for="">Confirm Password</label>
              <input
                type="password"
                class="form-control"
                id="account-password-confirm"
                name="confirm-password"
                placeholder="Password"
                required
              />
            </div>
            <div class="form-group">
              <input
                type="submit"
                value="Change Password"
                class="btn"
                id="change-pass-btn"
                name="change_password"
              />
            </div>
          </form>
        </div>
      </div>
    </section>

    <!-- Orders -->
    <section id="orders" class="orders container my-5 py-3">
      <div class="container mt-2">
        <h2 class="font-weight-bold text-center">Your Orders</h2>
        <hr class="mx-auto" />
      </div>

      <table class="mt-5 pt-5">
        <tr>
          <th>Order id</th>
          <th>Order cost</th>
          <th>Order status</th>
          <th>Order Date</th>
          <th>Order details</th>
        </tr>

        <?php while($row = $orders->fetch_assoc() ){ ?>

          <tr>
            <td>
              <!-- <div class="product-info">
                <img src="assets/imgs/1.png" alt="" />
                <div>
                  <p class="mt-3"><?php echo $row['order_id']; ?></p>
                </div>
              </div> -->
              <span><?php echo $row['order_id']; ?></span>
            </td>

            <td>
              <span><?php echo $row['order_cost']; ?></span>
            </td>

            <td>
              <span><?php echo $row['order_status']; ?></span>
            </td>

            <td>
              <span><?php echo $row['order_date']; ?></span>
            </td>

            <td>
              <form method="GET" action="order_details.php">
                <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id"/>
                <input class="btn order-details-btn" name="order_details_btn" type="submit" value="details">
              </form>
            </td>


            <td>
              <span>01-01-2025</span>
            </td>
          </tr>

          <?php } ?>

      </table>
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
