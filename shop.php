<?php include('layouts/header.php') ?>
<link rel="stylesheet" href="assets/css/style.css?v=6">

<?php

include('server/connection.php');

//use search section
if (isset($_POST['search'])) {

  if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
     $page_no = $_GET['page_no'];
  } else {
     $page_no = 1;
  }


  // price filter 
    $category = $_POST['category'];
    $price    = (int)$_POST['price'];
    $isAll    = ($category === '' || strtolower($category) === 'all'); 
   

  // Return number of products
   if ($isAll) {
  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products WHERE product_price <= ?");
    $stmt1->bind_param("i", $price);} else {
      $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products WHERE product_category = ? AND product_price <= ?");
    $stmt1->bind_param("si", $category, $price);} 

  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();


  $total_records_per_page = 8;

  $offset = ($page_no - 1) * $total_records_per_page;

  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $adjacents = 2;

  $total_no_of_pages = ceil($total_records / $total_records_per_page);

  if ($isAll) {
    $stmt2 = $conn->prepare("SELECT * FROM products WHERE product_price <= ? LIMIT $offset, $total_records_per_page");
    $stmt2->bind_param("i", $price); } 
    else {
       $stmt2 = $conn->prepare("SELECT * FROM products WHERE product_category = ? AND product_price <= ? LIMIT $offset, $total_records_per_page");
    $stmt2->bind_param("si", $category, $price);
    }
  
     $stmt2->execute();
     $products = $stmt2->get_result();




      } 
       elseif (isset($_GET['cat']) && $_GET['cat'] !== '')
   
   {

     if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
     $page_no = (int)$_GET['page_no'];
      } else 
    {
         $page_no = 1;
    }

  $category = $_GET['cat'];
  $price    = 200; 

  // Count for pagination
  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records
                           FROM products
                           WHERE product_category = ? AND product_price <= ?");
  $stmt1->bind_param("si", $category, $price);
  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();

  $total_records_per_page = 8;
  $offset = ($page_no - 1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;
  $adjacents = 2;
  $total_no_of_pages = ceil($total_records / $total_records_per_page);


$stmt2 = $conn->prepare("SELECT * FROM products
                           WHERE product_category = ? AND product_price <= ?
                           LIMIT $offset, $total_records_per_page");
  $stmt2->bind_param("si", $category, $price);
  $stmt2->execute();
  $products = $stmt2->get_result();

  $ui_price_value = $price;
  $ui_category    = $category;
    
    

    } else{

     if (isset($_GET['page_no']) && $_GET['page_no'] != "")
   {
   
    $page_no = $_GET['page_no'];
     } else {
   
        $page_no = 1;
    }

  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();


  $total_records_per_page = 8;

  $offset = ($page_no - 1) * $total_records_per_page;

  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $adjacents = 2; 

  $total_no_of_pages = ceil($total_records / $total_records_per_page);

  $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset, $total_records_per_page");
  $stmt2->execute();
  $products = $stmt2->get_result();

}

     $ui_price_value = isset($price) ? (int)$price : 1000;///price 
     $ui_category    = isset($category) ? $category : '';



?>

<!-- Product Page -->
<section id="shop" class="my-5 py-5">
  <div class="container mt-5 py-5">
    <div class="row">


      <!-- Search Filters -->
<div class="col-lg-3 col-md-4 col-sm-12">
  <h4>Search Product</h4>
  <hr>

  <form action="shop.php" method="POST" class="filter-card">

    <p class="mb-2 fw-bold">Category : </p>
    <div class="category-filter">

   
      
<div class="form-check">
  <input class="form-check-input" type="radio" name="category" id="cat_all" value=""
         <?php if ($ui_category === '') echo 'checked'; ?> />
  <label class="form-check-label" for="cat_all">All</label>
</div>


      <div class="form-check">
        <input class="form-check-input" type="radio" name="category" id="cat_we" value="Writing Essentials"
          <?php if ($ui_category === 'Writing Essentials') echo 'checked'; ?> />
        <label class="form-check-label" for="cat_we">Writing Essentials</label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="category" id="cat_np" value="Notebooks & Paper"
          <?php if ($ui_category === 'Notebooks & Paper') echo 'checked'; ?> />
        <label class="form-check-label" for="cat_np">Notebooks & Paper</label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="category" id="cat_da" value="Desk Accessories"
          <?php if ($ui_category === 'Desk Accessories') echo 'checked'; ?> />
        <label class="form-check-label" for="cat_da">Desk Accessories</label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="category" id="cat_cs" value="Creative Supplies"
          <?php if ($ui_category === 'Creative Supplies') echo 'checked'; ?> />
        <label class="form-check-label" for="cat_cs">Creative Supplies</label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="category" id="cat_st" value="Study Tools"
          <?php if ($ui_category === 'Study Tools') echo 'checked'; ?> />
        <label class="form-check-label" for="cat_st">Study Tools</label>
      </div>
    </div>

    <div class="mt-4">
      <p class="mb-1 fw-bold">Price :</p>
      <div class="price-row">
        <input
          type="range"
          class="form-range flex-grow-1"
          name="price"
          id="priceRange"
          min="1" max="200"
          value="<?php echo $ui_price_value; ?>" />
        <span class="price-chip" id="priceValue">$<?php echo number_format($ui_price_value, 0); ?></span>
      </div>
      <div class="d-flex justify-content-between small text-muted mt-1">
        <span>$1</span><span>$200</span>
      </div>
    </div>

    <div class="row g-2 my-3">
      <div class="col-6">
    <a href="shop.php" id="filterReset" class="btn btn-outline-secondary w-100">Reset</a>
      </div>
      <div class="col-6">
    <input type="submit" name="search" value="Search" class="btn btn-primary w-100">
      </div>
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
              <a class="page-link" href="<?php echo ($page_no > 1) ? '?page_no='.($page_no-1).(isset($_GET['cat']) ? '&cat='.urlencode($_GET['cat']) : '')  : '#'; ?>">Previous</a>
            </li>

            <!-- Page Numbers  -->
            <!-- 1 -->
            <li class="page-item">
              <a class="page-link" href="<?php
                echo '?page_no=1'.(isset($_GET['cat']) ? '&cat='.urlencode($_GET['cat']) : ''); ?>">1</a>
            </li>

            <!-- 2 -->
            <li class="page-item">
              <a class="page-link" href="<?php
                echo '?page_no=2'.(isset($_GET['cat']) ? '&cat='.urlencode($_GET['cat']) : ''); ?>">2</a>
            </li>
            <!-- 3-->
            <?php if ($page_no >= 3) { ?>
              <li class="page-item"><a class="page-link" href="#">...</a></li>
              <li class="page-item"><a class="page-link"
                  href="<?php echo '?page_no='.$page_no.(isset($_GET['cat']) ? '&cat='.urlencode($_GET['cat']) : '');?>"><?php echo $page_no; ?></a></li>
            <?php } ?>

            <!-- Next Button -->
            <li class="page-item <?php if ($page_no >= $total_no_of_pages)
              echo 'disabled'; ?>">
              <a class="page-link" href="<?php 
              echo ($page_no < $total_no_of_pages)
              ? '?page_no='.($page_no+1).(isset($_GET['cat']) ? '&cat='.urlencode($_GET['cat']) : '') : '#'; ?>">Next</a>
            </li>
          </ul>
        </nav>

      </div>
    </div>
  </div>
</section>
<script>
// price + reset behavior
(function(){
  const slider = document.getElementById('priceRange');
  const out    = document.getElementById('priceValue');
  const fmt  = v => '$' + Number(v).toFixed(0);
  const sync = () => { if (out && slider) out.textContent = fmt(slider.value); };
  if (slider) slider.addEventListener('input', sync);
  sync();
})();
</script>



<?php include('layouts/footer.php') ?>