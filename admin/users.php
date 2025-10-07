<?php
include('header.php');
include('../server/connection.php');

// Pagination logic
$page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? intval($_GET['page_no']) : 1;
$total_records_per_page = 10;
$offset = ($page_no - 1) * $total_records_per_page;

// Get total users
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM users");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();
$stmt1->close();
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// Get users for current page
$stmt2 = $conn->prepare("SELECT user_id, user_name, user_email FROM users ORDER BY user_id ASC LIMIT ?, ?");
$stmt2->bind_param('ii', $offset, $total_records_per_page);
$stmt2->execute();
$users = $stmt2->get_result();
$stmt2->close();
?>

<div class="container-fluid">
  <div class="row">
    <?php include('sidemenu.php'); ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <br>
      <h2>Users</h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">User ID</th>
              <th scope="col">User Name</th>
              <th scope="col">User Email</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user) { ?>
              <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo htmlspecialchars($user['user_name']); ?></td>
                <td><?php echo htmlspecialchars($user['user_email']); ?></td>
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
    </main>
  </div>
</div>

<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" crossorigin="anonymous"></script>
<script>feather.replace();</script>
