<?php
// --- checkout.php ---

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// If cart is empty, send user home
if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
  header('Location: index.php');
  exit;
}

// Totals are already calculated in cart.php (subtotal, discount, total)
// so we just display them here.

include('layouts/header.php');
?>

<!-- Checkout -->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="form-weight-bold">Check Out</h2>
    <hr class="mx-auto" />
  </div>

  <div class="mx-auto container">
    <form id="checkout-form" method="POST" action="server/place_order.php">
      <p class="text-center" style="color: red;">
        <?php if (isset($_GET['message'])) { echo htmlspecialchars($_GET['message']); } ?>
        <?php if (isset($_GET['message'])) { ?>
          <a href="login.php" class="btn btn-primary">Login</a>
        <?php } ?>
      </p>

      <div class="form-group checkout-small-element">
        <label for="checkout-name">Name</label>
        <input
          type="text"
          class="form-control"
          id="checkout-name"
          name="name"
          placeholder="Name"
          required
        />
      </div>

      <div class="form-group checkout-small-element">
        <label for="checkout-email">Email</label>
        <input
          type="email"
          class="form-control"
          id="checkout-email"
          name="email"
          placeholder="Email"
          required
        />
      </div>

      <div class="form-group checkout-small-element">
        <label for="checkout-phone">Phone</label>
        <input
          type="tel"
          class="form-control"
          id="checkout-phone"
          name="phone"
          placeholder="Phone"
          required
        />
      </div>

      <div class="form-group checkout-small-element">
        <label for="checkout-city">City</label>
        <input
          type="text"
          class="form-control"
          id="checkout-city"
          name="city"
          placeholder="City"
          required
        />
      </div>

      <div class="form-group checkout-large-element">
        <label for="checkout-address">Address</label>
        <input
          type="text"
          class="form-control"
          id="checkout-address"
          name="address"
          placeholder="Address"
          required
        />
      </div>

      <div class="form-group checkout-btn-container d-flex align-items-center justify-content-between">
        <p class="mb-0">
          <strong>Total amount:</strong>
          $ <?= number_format($_SESSION['total'] ?? 0, 2) ?>
        </p>

        <input
          type="submit"
          class="btn"
          id="checkout-btn"
          name="place_order"
          value="Place Order"
        />
      </div>
    </form>
  </div>
</section>

<?php include('layouts/footer.php'); ?>
