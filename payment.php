<?php
  session_start();
?>

<?php include('layouts/header.php') ?>

    <!-- Payment -->
    <section class="my-5 py-5">
      <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto" />
      </div>
      <div class="mx-auto container text-center">
        <p><?php echo $_GET['order_status']; ?></p>
        <p>Total payment: $<?php echo $_SESSION['total']; ?></p>
        <input class="btn btn-primary" type="submit" value="Pay Now">
      </div>
    </section>

  <?php include('layouts/footer.php') ?>
