<?php include('header.php'); ?>


<?php

if (!isset($_SESSION['admin_logged_in'])) {
  header('location: login.php');
  exit();
}

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
  $page_no = $_GET['page_no'];
} else {
  $page_no = 1;
}

// Return number of promo codes
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM promo_codes");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

$total_records_per_page = 10;
$offset = ($page_no - 1) * $total_records_per_page;
$total_no_of_pages = ceil($total_records / $total_records_per_page);

$stmt2 = $conn->prepare("SELECT * FROM promo_codes LIMIT ?, ?");
$stmt2->bind_param("ii", $offset, $total_records_per_page);
$stmt2->execute();
$promo_codes = $stmt2->get_result();

?>

<div class="container-fluid">
  <div class="row">
    <?php include('sidemenu.php'); ?>

    <style>
      /* Button to Add New Promo Code */
      #add-new-promo-btn {
          background-color: #FF9F7F; /* Pale Orange */
          color: black;
          border-radius: 5px;
          padding: 5px 15px;
          font-size: 0.9rem;
          font-weight: 500;
          text-decoration: none; /* Remove underline */
          position: absolute; /* Position relative to the nearest positioned ancestor */
          top: 90px; /* Adjust this to your preference */
          right: 30px; /* Distance from the right edge */
          z-index: 10;
      }

      #add-new-promo-btn:hover {
          background-color: #FF7F50;
      }
    </style>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <br>
      <h2>Promo Codes</h2>

      <a href="add_promo_code.php" class="btn" id="add-new-promo-btn">
        + Add New Promo Code
      </a>

      <!-- Display Messages -->
      <?php if (isset($_GET['promo_code_created'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['promo_code_created']; ?></p>
      <?php } ?>
      <?php if (isset($_GET['promo_code_failed'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['promo_code_failed']; ?></p>
      <?php } ?>
      <?php if (isset($_GET['edit_success_message'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['edit_success_message']; ?></p>
      <?php } ?>
      <?php if (isset($_GET['edit_failure_message'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['edit_failure_message']; ?></p>
      <?php } ?>
      <?php if (isset($_GET['deleted_successfully'])) { ?>
        <p class="text-center" style="color: green;"><?php echo $_GET['deleted_successfully']; ?></p>
      <?php } ?>
      <?php if (isset($_GET['deleted_failure'])) { ?>
        <p class="text-center" style="color: red;"><?php echo $_GET['deleted_failure']; ?></p>
      <?php } ?>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Code</th>
              <th scope="col">Discount</th>
              <th scope="col">Min. Purchase</th>
              <th scope="col">Expires On</th>
              <th scope="col">Edit</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($promo_codes as $promo_code) { ?>
              <tr>
                <td><?php echo $promo_code['id']; ?></td>
                <td><strong><?php echo $promo_code['code']; ?></strong></td>
                <td>
                  <?php if ($promo_code['discount_type'] == 'fixed') {
                    echo "$" . number_format($promo_code['discount_value'], 2);
                  } else {
                    echo (int)$promo_code['discount_value'] . "%";
                  } ?>
                </td>
                <td><?php echo "$" . number_format($promo_code['min_purchase'], 2); ?></td>
                <td><?php echo $promo_code['end_date'] ? date('M j, Y', strtotime($promo_code['end_date'])) : 'N/A'; ?></td>
                <td>
                  <a class="btn btn-primary" href="edit_promo_code.php?promo_code_id=<?php echo $promo_code['id']; ?>">Edit</a>
                </td>
                <td>
                  <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                    data-promo-code="<?php echo htmlspecialchars($promo_code['code']); ?>"
                    data-delete-url="delete_promo_code.php?promo_code_id=<?php echo $promo_code['id']; ?>">
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
            <li class="page-item <?php if ($page_no <= 1) echo 'disabled'; ?>">
              <a class="page-link" href="<?php if ($page_no <= 1) { echo '#'; } else { echo "?page_no=" . ($page_no - 1); } ?>">Previous</a>
            </li>
            <!-- Dynamic Page Numbers -->
            <?php
            if ($total_no_of_pages > 0) {
              for ($i = 1; $i <= $total_no_of_pages; $i++) {
                $active = ($i == $page_no) ? 'active' : '';
                echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page_no=' . $i . '">' . $i . '</a></li>';
              }
            }
            ?>
            <!-- Next Button -->
            <?php
            $next_offset = $page_no * $total_records_per_page;
            $show_next = ($next_offset < $total_records);
            ?>
            <li class="page-item <?php if (!$show_next) echo 'disabled'; ?>">
              <a class="page-link" href="<?php if (!$show_next) { echo '#'; } else { echo "?page_no=" . ($page_no + 1); } ?>">Next</a>
            </li>
          </ul>
        </nav>
      </div>

      <!-- Modal Styles -->
      <style>
        .modal-header { justify-content: center; }
        .modal-header .btn-close { position: absolute; right: 1rem; top: 1rem; }
        .modal-footer #cancelBtn, .modal-footer #confirmDeleteBtn { padding-left: 50px; padding-right: 50px; }
      </style>

      <!-- Delete Confirmation Modal -->
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title" id="deleteModalLabel"><b>Delete Promo Code</b></h2>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              Are you sure you want to delete the code "<strong><span id="modalPromoCode"></span></strong>"?
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
<script>
  feather.replace();

  // Handle modal data population for promo codes
  var deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var promoCode = button.getAttribute('data-promo-code');
    var deleteUrl = button.getAttribute('data-delete-url');
    document.getElementById('modalPromoCode').textContent = promoCode;
    document.getElementById('confirmDeleteBtn').setAttribute('href', deleteUrl);
  });
</script>

</body>
</html>