<?php include('layouts/header.php') ?>

<?php 
include('server/connection.php');

if(isset($_GET['product_id'])){

  $product_id = $_GET['product_id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt-> bind_param("i", $product_id);


$stmt->execute();


$product = $stmt->get_result();  


//no product id was given
}else{
        
  header('location: index.php');

}


?>

    <!-- Single Product -->
    <section class="container single-product my-5 pt-5">
      <div class="row mt-5">
        
      <?php while($row = $product->fetch_assoc()){ ?>
       
     



        <div class="col-lg-5 col-md-6 col-sm-12">
          <img id="mainImg" class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image']; ?>" alt="" />
          <div class="small-img-group">
            <div class="small-img-col">
              <img
                class="small-img"
                src="assets/imgs/<?php echo $row['product_image']; ?>"
                width="100%"
                alt=""
              />
            </div>
            <div class="small-img-col">
              <img
                class="small-img"
                src="assets/imgs/<?php echo $row['product_image2']; ?>"
                width="100%"
                alt=""
              />
            </div>
            <div class="small-img-col">
              <img
                class="small-img"
                src="assets/imgs/<?php echo $row['product_image3']; ?>"
                width="100%"
                alt=""
              />
            </div>
            <div class="small-img-col">
              <img
                class="small-img"
                src="assets/imgs/<?php echo $row['product_image4']; ?>"
                width="100%"
                alt=""
              />
            </div>
          </div>
        </div>




        <div class="col-lg-6 col-md-12 col-12">
          <h6>Stationary</h6>
          <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
          <h2>$<?php echo $row['product_price']; ?></h2>

          <form method="POST" action="cart.php">
          <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
          <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
          <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/>
          <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>

          <input type="number" name="product_quantity" value="1" />
          <button class="buy-btn" type="submit" name="add_to_cart">Add To Cart</button>
          </form>

          
          <h4 class="mt-5 mb-5">Product Details</h4>
          <span>
            <?php echo $row['product_description']; ?>
          </span>
        </div>
   
        <?php } ?>

      </div>
    </section>

    <!-- Related Products -->
    <section id="featured" class="my-5 pb-5">
      <div class="container text-center mt-5 py-5">
        <h3>Related Products</h3>
        <hr class="mx-auto" />
      </div>

      <div class="row mx-auto container-fluid">
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img class="img-fluid mb-3" src="assets/imgs/1.png" alt="" />

          <div class="star">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>

          <h5 class="p-name">Product</h5>
          <h4 class="p-price">$199</h4>
          <button class="buy-btn">Buy Now</button>
        </div>

        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img class="img-fluid mb-3" src="assets/imgs/1.png" alt="" />

          <div class="star">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>

          <h5 class="p-name">Product</h5>
          <h4 class="p-price">$199</h4>
          <button class="buy-btn">Buy Now</button>
        </div>

        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img class="img-fluid mb-3" src="assets/imgs/1.png" alt="" />

          <div class="star">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>

          <h5 class="p-name">Product</h5>
          <h4 class="p-price">$199</h4>
          <button class="buy-btn">Buy Now</button>
        </div>

        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img class="img-fluid mb-3" src="assets/imgs/1.png" alt="" />

          <div class="star">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>

          <h5 class="p-name">Product</h5>
          <h4 class="p-price">$199</h4>
          <button class="buy-btn">Buy Now</button>
        </div>
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

  

    <script>
        var mainImg = document.getElementById("mainImg");
        var smallImg = document.getElementsByClassName("small-img");

        for(let i=0; i<4; i++) {
            smallImg[i].onclick = function() {
                mainImg.src = smallImg[i].src;
            }
        }

    </script>

<?php include('layouts/footer.php') ?>

