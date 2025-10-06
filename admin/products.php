<?php include('header.php'); ?>


<?php

if (!isset($_SESSION['admin_logged_in'])) {
  header('location: login.php');
  exit();
}



?>



<?php

// get orders
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

// display number of records (orders) per page
$total_records_per_page = 10;

$offset = ($page_no - 1) * $total_records_per_page;

$previous_page = $page_no - 1;
$next_page = $page_no + 1;

$adjacents = 2; // Number of adjacent pages on either side of the current page

$total_no_of_pages = ceil($total_records / $total_records_per_page);

$stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset, $total_records_per_page");
$stmt2->execute();
$products = $stmt2->get_result();


?>




<div class="container-fluid">
  <div class="row">

    <?php include('sidemenu.php'); ?>

    </main>

    <style>
      /* Add New Product Button - Positioning */
      #add-new-product-btn {
        background-color: #FF9F7F;
        /* Pale Orange */
        color: black;
        border-radius: 5px;
        padding: 5px 15px;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        /* Remove underline */
        position: absolute;
        /* Position relative to the nearest positioned ancestor */
        top: 90px;
        /* Adjust this to your preference (distance from the top) */
        right: 30px;
        /* Distance from the right edge */
        z-index: 10;
        /* Ensures the button appears above other elements */
      }

      #add-new-product-btn:hover {
        background-color: #FF7F50;
        /* Slightly darker orange on hover */
      }
    </style>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <br>
      <h2>Products</h2>

      <a href="add_product.php" class="btn btn-signout" id="add-new-product-btn">
        + Add New Product
      </a>


      <!-- Edit product messages -->
      <?php if (isset($_GET['edit_success_message'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['edit_success_message']; ?></p>
      <?php } ?>

      <?php if (isset($_GET['edit_failure_message'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['edit_failure_message']; ?></p>
      <?php } ?>

      <?php if (isset($_GET['stock_success_message'])) { ?>
        <p class="text-center" style="color: green;"><?php echo htmlspecialchars($_GET['stock_success_message']); ?></p>
      <?php } ?>

      <?php if (isset($_GET['stock_failure_message'])) { ?>
        <p class="text-center" style="color: red;"><?php echo htmlspecialchars($_GET['stock_failure_message']); ?></p>
      <?php } ?>




      <!-- Delete product message -->
      <?php if (isset($_GET['deleted_successfully'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['deleted_successfully']; ?></p>
      <?php } ?>

      <?php if (isset($_GET['deleted_failure'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['deleted_failure']; ?></p>
      <?php } ?>

      <!-- Create product -->
      <?php if (isset($_GET['product_created'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['product_created']; ?></p>
      <?php } ?>

      <?php if (isset($_GET['product_failed'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['product_failed']; ?></p>
      <?php } ?>

      <!-- Update images -->
      <?php if (isset($_GET['images_updated'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['images_updated']; ?></p>
      <?php } ?>

      <?php if (isset($_GET['images_failed'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['images_failed']; ?></p>
      <?php } ?>



      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Product ID</th>
              <th scope="col">Product Image</th>
              <th scope="col">Product Name</th>
              <th scope="col">Product Price</th>
              <th scope="col">Stock</th>
              <th scope="col">Market Price</th>
              <th scope="col">Product Category</th>
              <th scope="col">Edit</th>
              <th scope="col">Delete</th>


            </tr>
          </thead>
          <tbody>

            <?php foreach ($products as $product) { ?>
              <tr>
                <td><?php echo $product['product_id']; ?></td>
                <td><img src="<?php echo "../assets/imgs/" . $product['product_image']; ?>"
                    style="width: 70px; height: 70px;"></td>
                <td><?php echo $product['product_name']; ?></td>
                <td><?php echo "$" . $product['product_price']; ?></td>

                <td>
                  <?php $stock = isset($product['product_stock']) ? (int) $product['product_stock'] : 0;
                  // color code
                  if ($stock === 0) {
                    $badge = 'bg-secondary';
                  } elseif ($stock <= 5) {
                    $badge = 'bg-danger';              // low
                  } elseif ($stock <= 20) {
                    $badge = 'bg-warning text-dark';   // medium
                  } else {
                    $badge = 'bg-success';             // high
                  } ?>
                  <span class="badge <?php echo $badge; ?>"><?php echo $stock; ?></span>
                </td>




                <td>
                  <?php echo isset($product['market_price']) ? "$" . number_format($product['market_price'], 2) : '-'; ?>
                </td>
                <td><?php echo $product['product_category']; ?></td>
                <td><a class="btn btn-primary"
                    href="edit_product.php?product_id=<?php echo $product['product_id']; ?>">Edit</a></td>
                <td>
                  <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                    data-product-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                    data-delete-url="delete_product.php?product_id=<?php echo $product['product_id']; ?>">
                    Delete
                  </button>
                </td>

              </tr>

            <?php } ?>

          </tbody>
        </table>


        <nav aria-label="Page navigation example" class="mx-auto">
          <ul class="pagination mt-5 mx-auto">

            <!-- Previous Button -->
            <li class="page-item <?php if ($page_no <= 1)
              echo 'disabled'; ?>">
              <a class="page-link" href="<?php if ($page_no <= 1) {
                echo '#';
              } else {
                echo "?page_no=" . ($page_no - 1);
              } ?>">Previous</a>
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
              <a class="page-link" href="<?php if ($page_no >= $total_no_of_pages) {
                echo '#';
              } else {
                echo "?page_no=" . ($page_no + 1);
              } ?>">Next</a>
            </li>

          </ul>
        </nav>


      </div>

      <!-- Center modal-header -->
      <style>
        .modal-header {
          justify-content: center;
        }

        .modal-header .btn-close {
          position: absolute;
          right: 1rem;
          top: 1rem;
        }

        .modal-footer #cancelBtn,
        .modal-footer #confirmDeleteBtn {
          padding-left: 50px;
          padding-right: 50px;

        }
      </style>

      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title" id="deleteModalLabel"><b>Delete Product</b></h2>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              Are you sure you want to delete "<span id="modalProductName"></span>"?
            </div>
            <div class="modal-footer justify-content-center">
              <button id="cancelBtn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <a href="#" id="confirmDeleteBtn" class="btn btn-danger ms-2">Delete</a>
            </div>
          </div>
        </div>
      </div>

    </main>


  </div>


</div>


<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
  integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
  integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
<script src="dashboard.js"></script>

<script>
  // Handle modal data population
  var deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var productName = button.getAttribute('data-product-name');
    var deleteUrl = button.getAttribute('data-delete-url');
    document.getElementById('modalProductName').textContent = productName;
    document.getElementById('confirmDeleteBtn').setAttribute('href', deleteUrl);
  });
</script>