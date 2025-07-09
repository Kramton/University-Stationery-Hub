<?php
session_start();

if (isset($_POST['order_pay_btn'])) {
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

    <?php if (isset($_SESSION['total']) && $_SESSION['total'] != 0) { ?>
      <p>Total payment: $<?php echo $_SESSION['total']; ?></p>
      <!-- <input class="btn btn-primary" type="submit" value="Pay Now"> -->
      <!-- Set up container element for the button -->
      <div id="paypal-button-container"></div>

    <?php } else if (isset($_POST['order_status']) && $_POST['order_status'] == "not paid") { ?>
        <p>Total Payment: $<?php echo $_POST['order_total_price']; ?></p>
        <!-- <input class="btn btn-primary" type="submit" value="Pay Now"> -->
        <!-- Set up container element for the button -->
        <div id="paypal-button-container"></div>

    <?php } else { ?>
        <p>Your cart is empty!</p>
    <?php } ?>



  </div>
</section>


<p id="result-message"></p>
<!-- Initialize the JS-SDK -->
<script
  src="https://www.paypal.com/sdk/js?client-id=AYVYkWacTQ3tL6cxbCL_dadNr50VG2t0_Lhc3zKvlOA-h_tmHoAgQ7a7CdpkKcutRDig3PTuwYMrJP8c&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
  data-sdk-integration-source="developer-studio"></script>
<script src="app.js"></script>

<?php include('layouts/footer.php') ?>