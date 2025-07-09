<?php
session_start();

if(isset($_POST['order_pay_btn'])) {
  $order_status = $_POST['order_status'];
  $order_total_price = $_POST['order_total_price'];
}


?>

<?php include('layouts/header.php') ?>

    <!-- Payment -->
    <section class="my-5 py-5">
      <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Payment</h2>
        <hr class="mx-auto" />
      </div>
      <div class="mx-auto container text-center">
        
        <p>Total payment: $<?php if(isset($_SESSION['total'])){ echo $_SESSION['total'];} ?></p>
        <?php if(isset($_SESSION['total']) && $_SESSION['total'] != 0){ ?>
        <!-- <input class="btn btn-primary" type="submit" value="Pay Now"> -->
        <?php } else { ?>
          <p>Your cart is empty!</p>
        <?php } ?>

        <p><?php if(isset($_POST['order_status'])) {echo $_POST['order_status'];} ?></p>

        <?php if(isset($_POST['order_status']) && $_POST['order_status'] == "not paid") { ?>
        <input class="btn btn-primary" type="submit" value="Pay Now">
        <?php } ?>
      </div>
    </section>

  <?php include('layouts/footer.php') ?>
