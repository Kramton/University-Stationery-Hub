<?php include('layouts/header.php') ?>

<?php

include('server/connection.php');

//use search section
if (isset($_POST['search'])) {

  if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    // If user has already entered page then page number is the one that they selected
    $page_no = $_GET['page_no'];
  } else {
    // If user just entered the page then default page is 1
    $page_no = 1;
  }



  $category = $_POST['category'];
  $price = $_POST['price'];

  // Return number of products
  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products WHERE product_category=? AND product_price<=?");
  $stmt1->bind_param("si", $category, $price);
  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();


  $total_records_per_page = 8;

  $offset = ($page_no - 1) * $total_records_per_page;

  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $adjacents = 2; // Number of adjacent pages on either side of the current page

  $total_no_of_pages = ceil($total_records / $total_records_per_page);

  $stmt2 = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_price<=? LIMIT $offset, $total_records_per_page");
  $stmt2->bind_param("si", $category, $price);
  $stmt2->execute();
  $products = $stmt2->get_result();//[]






  //return all products 
} else {

  if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    // If user has already entered page then page number is the one that they selected
    $page_no = $_GET['page_no'];
  } else {
    // If user just entered the page then default page is 1
    $page_no = 1;
  }

  // Return number of products
  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();


  $total_records_per_page = 8;

  $offset = ($page_no - 1) * $total_records_per_page;

  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $adjacents = 2; // Number of adjacent pages on either side of the current page

  $total_no_of_pages = ceil($total_records / $total_records_per_page);

  $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset, $total_records_per_page");
  $stmt2->execute();
  $products = $stmt2->get_result();

}


?>

<!-- Product Page -->
<section id="shop" class="my-5 py-5">
  <div class="container mt-5 py-5">
    <div class="row">

      <!-- Search Filters -->
      <div class="col-lg-3 col-md-4 col-sm-12">
        <h4>Search Product</h4>
        <hr>

        <form action="shop.php" method="POST">

          <p>Category</p>
          <div class="form-check">
            <input class="form-check-input" value="Writing Essentials" type="radio" name="category" id="category_one"
              <?php if (isset($category) && $category == 'Writing Essentials')
                echo 'checked'; ?>>
            <label class="form-check-label" for="category_one">Writing Essentials</label>
          </div>

          <div class="form-check">
            <input class="form-check-input" value="Notebooks & Paper" type="radio" name="category" id="category_two"
              <?php if (isset($category) && $category == 'Notebooks & Paper')
                echo 'checked'; ?>>
            <label class="form-check-label" for="category_two">Notebooks & Paper</label>
          </div>

          <div class="form-check">
            <input class="form-check-input" value="Desk Accessories" type="radio" name="category" id="category_three"
              <?php if (isset($category) && $category == 'Desk Accessories')
                echo 'checked'; ?>>
            <label class="form-check-label" for="category_three">Desk Accessories</label>
          </div>

          <div class="form-check">
            <input class="form-check-input" value="Creative Supplies" type="radio" name="category" id="category_four"
              <?php if (isset($category) && $category == 'Creative Supplies')
                echo 'checked'; ?>>
            <label class="form-check-label" for="category_four">Creative Supplies</label>
          </div>

          <div class="form-check">
            <input class="form-check-input" value="Study Tools" type="radio" name="category" id="category_five"
              <?php if (isset($category) && $category == 'Study Tools') echo 'checked'; ?>>
            <label class="form-check-label" for="category_five">Study Tools</label>
          </div>

          <div class="mt-4">
            <p>Price</p>
            <input type="range" class="form-range w-100" name="price" value="<?php if (isset($price))
              echo $price; ?>"
              min="1" max="1000" id="customRange2">
            <div>
              <span style="float:left;">1</span>
              <span style="float:right;">1000</span>
            </div>
          </div>

          <div class="form-group my-3">
            <input type="submit" name="search" value="Search" class="btn btn-primary w-100">
          </div>

        </form>
      </div>

      <!-- Product List -->
      <div class="col-lg-9 col-md-8 col-sm-12">

        <!-- Title -->
        <div class="text-center mb-4">
          <h3>Our Products</h3>
          <hr class="mx-auto" />
          <p>Here you can check out our products</p>
        </div>

        <!-- Product Grid -->
        <div class="row">
          <?php while ($row = $products->fetch_assoc()) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6 d-flex">
              <div class="product d-flex flex-column w-100"
                onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id']; ?>'">


                <!-- Product image -->
                <img class="img-fluid" src="assets/imgs/<?php echo $row['product_image']; ?>"
                  alt="<?php echo $row['product_name']; ?>">

                <!-- Name and price -->
                <div class="p-info">
                  <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                  <h4 class="p-price">$<?php echo $row['product_price']; ?></h4>
                </div>

                <!-- Button at bottom -->
                <a href="single_product.php?product_id=<?php echo $row['product_id']; ?>" class="buy-btn w-100">
                  Buy Now
                </a>

              </div>
            </div>

          <?php } ?>
        </div>


        <!-- Pagination -->
        <nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
          <ul class="pagination">
            <!-- Previous Button -->
            <li class="page-item <?php if ($page_no <= 1)
              echo 'disabled'; ?>">
              <a class="page-link"
                href="<?php if ($page_no > 1)
                  echo "?page_no=" . ($page_no - 1);
                else
                  echo '#'; ?>">Previous</a>
            </li>

            <!-- Page Numbers -->
            <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
            <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>

            <?php if ($page_no >= 3) { ?>
              <li class="page-item"><a class="page-link" href="#">...</a></li>
              <li class="page-item"><a class="page-link"
                  href="<?php echo "?page_no=" . $page_no; ?>"><?php echo $page_no; ?></a></li>
            <?php } ?>

            <!-- Next Button -->
            <li class="page-item <?php if ($page_no >= $total_no_of_pages)
              echo 'disabled'; ?>">
              <a class="page-link"
                href="<?php if ($page_no < $total_no_of_pages)
                  echo "?page_no=" . ($page_no + 1);
                else
                  echo '#'; ?>">Next</a>
            </li>
          </ul>
        </nav>

      </div>
    </div>
  </div>
</section>


<?php include('layouts/footer.php') ?>