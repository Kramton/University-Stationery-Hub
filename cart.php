<?php

   session_start();

    if(isset($_POST['add_to_cart'])){

         // if user already added a product to cart
          if(isset($_SESSION['cart']))
          {
            $products_array_ids = array_column($_SESSION['cart'],"product_id");
            
            //if product has already been addedcto cart or not 
            if( !in_array($_POST['product_id'],$products_array_ids)){
                
             $product_id = $_POST['product_id'];

             $product_array = array(
                                'product_id' => $_POST['product_id'],
                                'product_name' => $_POST['product_name'],
                                'product_price' => $_POST['product_price'],
                                'product_image' => $_POST['product_image'],
                                'product_quantity' => $_POST['product_quantity']

             );
             $_SESSION['cart'][$product_id] = $product_array;
              //product has already been added
             } else {
              
                echo '<script>alert("Product was already to cart");</script>';
               // echo '<script>window.location="index.php";</script>';
             }
            
            
            // if this is the first product 
          }else {
            
            $product_id = $_POST['product_id'];
            $product_name =$_POST['product_name'];
            $product_price =$_POST['product_price'];
            $product_image = $_POST['product_image'];
            $product_quantity = $_POST['product_quantity'];

             $product_array = array(
                                'product_id' => $product_id,
                                'product_name' => $product_name,
                                'product_price' => $product_price,
                                'product_image' => $product_image,
                                'product_quantity' => $product_quantity

             );
             $_SESSION['cart'][$product_id] = $product_array;
             
          }
            // calculate total
            calculateTotalCart();
       



    // remove prodect from the cart 
    }else if(isset($_POST['remove_product'])){

      $product_id = $_POST['product_id'];
        unset($_SESSION['cart'][$product_id]);

         // calculate total 
         calculateTotalCart();



    }else if ( isset($_POST['edit_quantity'])){

      //got id and quantity from the form 
           $product_id = $_POST['product_id'];
           $product_quantity = $_POST['product_quantity'];
           

          //get the product array  from the session
           $product_array = $_SESSION['cart'][$product_id];

           //update product quantity
         $product_array['product_quantity'] = $product_quantity;
         //return array back its place
         $_SESSION['cart'][$product_id] = $product_array;


         // calculate total
         calculateTotalCart();


    }
    else{
      // If the user shouldn't be able to access the cart page, uncomment this code
     // header('location: index.php');
    }

      function calculateTotalCart(){
         
         $total = 0;

          foreach($_SESSION['cart'] as $key => $value)
          {
          $product = $_SESSION['cart'][$key];
          $price = $product['product_price'];
          $quantity = $product['product_quantity'];
          
          $total = $total + ($price * $quantity);
                 
 
         }
              
         $_SESSION['total']= $total;
      }





?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart</title>
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

    <!-- Cart -->
    <section class="cart container my-5 py-5">
      <div class="container mt-5">
        <h2 class="font-weight-bold text-center">Your Cart</h2>
        <hr class="mx-auto"/>
      </div>

      <table class="mt-5 pt-5">
        <tr>
          <th>Product</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>

         <?php foreach($_SESSION['cart'] as $key =>  $value){ ?>

        <tr>
          <td>
            <div class="product-info">
              <img src="assets/imgs/<?php echo $value['product_image']; ?>" />
              
              <div>
                <p><?php echo $value['product_name']; ?></p>
                <small><span>$</span><?php echo $value['product_price']; ?></small>
                <br>
                <form method="POST" action="cart.php">
                  <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                <input type="submit" name="remove_product" class="remove-btn" value="remove"/>
                </form>
                
              </div>
            </div>
          </td>

          <td>
            <form method="POST" action="cart.php">
              <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
              <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>" />

              <input type="submit" class="edit-btn" value="edit" name="edit_quantity"/>

            </form>
            
          </td>

          <td>
            <span>$</span>
            <span class="product-price"><?php echo $value['product_quantity'] * $value ['product_price']; ?></span>
          </td>
        </tr>
       
         <?php } ?>

      
      </table>



      <div class="cart-total">
        <table>
       <!--   <tr>
            <td>Subtotal</td>
            <td>$14</td>
          </tr>-->
          <tr>
            <td>Total</td>
            <td>$ <?php echo $_SESSION['total']; ?></td>
          </tr>
        </table>
      </div>

      <div class="checkout-container">
        <form method="PHP" action="checkout.php">
          <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
        </form>
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
