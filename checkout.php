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

/* ------- Helpers ------- */
function to_float($v)
{
  if (is_numeric($v))
    return (float) $v;
  $clean = preg_replace('/[^\d.]/', '', (string) $v);
  return $clean === '' ? 0.0 : (float) $clean;
}

/* ------- Build / normalize order snapshot ------- */
$order = $_SESSION['last_order'] ?? null;

if (!$order) {
  // Fallback to live cart so the page still works
  if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    echo '<section class="my-5 py-5"><div class="container text-center mt-3 pt-5"><h2 class="form-weight-bold">Payment</h2><hr class="mx-auto"/><p>Your cart is empty!</p></div></section>';
    require_once __DIR__ . '/layouts/footer.php';
    exit;
  }
  $items = [];
  $subtotal = 0.0;
  foreach ($_SESSION['cart'] as $it) {
    $name = $it['product_name'] ?? $it['name'] ?? 'Item';
    $qty = isset($it['product_quantity']) ? (int) $it['product_quantity'] : (int) ($it['quantity'] ?? 0);
    $price = isset($it['product_price']) ? to_float($it['product_price']) : to_float($it['price'] ?? 0);
    $line = $qty * $price;
    $subtotal += $line;
    $items[] = ['name' => $name, 'quantity' => $qty, 'subtotal' => $line];
  }
  $discount = (float) ($_SESSION['promo_discount'] ?? 0.0);
  $total = max(0, $subtotal - $discount);
  $order = [
    'order_id' => $_SESSION['order_id'] ?? 0,
    'items' => $items,
    'subtotal' => $subtotal,
    'discount' => $discount,
    'total' => $total,
  ];
} else {
  // Normalize keys from last_order
  $norm = [];
  $subtotal = 0.0;
  foreach ($order['items'] as $it) {
    $name = $it['name'] ?? $it['product_name'] ?? 'Item';
    $qty = isset($it['quantity']) ? (int) $it['quantity'] : (int) ($it['product_quantity'] ?? 0);
    if (isset($it['subtotal'])) {
      $line = to_float($it['subtotal']);
    } else {
      $price = isset($it['product_price']) ? to_float($it['product_price']) : to_float($it['price'] ?? 0);
      $line = $qty * $price;
    }
    $subtotal += $line;
    $norm[] = ['name' => $name, 'quantity' => $qty, 'subtotal' => $line];
  }
  $order['items'] = $norm;
  $order['subtotal'] = $order['subtotal'] ?? $subtotal;
  $order['discount'] = $order['discount'] ?? (float) ($_SESSION['promo_discount'] ?? 0.0);
  $order['total'] = $order['total'] ?? max(0, $order['subtotal'] - $order['discount']);
}

$amount = (float) $order['total'];
$order_id = (int) ($order['order_id'] ?? ($_SESSION['order_id'] ?? 0));
?>

?>



<style>
  /* Push down so Checkout title isn’t blocked by fixed header */
  .wrap {
    max-width: 1100px;
    margin: 120px auto 40px;
    padding: 0 16px
  }

  .title {
    font-size: 44px;
    font-weight: 800;
    text-align: center;
    margin: 10px 0 24px
  }

  .grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px
  }

  @media(max-width:900px) {
    .grid {
      grid-template-columns: 1fr
    }
  }

  /* Card with orange header & rounded corners */
  .card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 16px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
    overflow: hidden
  }

  .head {
    background: #f97316;
    color: #fff;
    padding: 16px 20px;
    font-size: 24px;
    font-weight: 800
  }

  .body {
    padding: 18px;
    background: #fff
  }

  /* Form */
  .row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px
  }

  .full {
    grid-column: 1/-1
  }

  label {
    font-weight: 700;
    margin-bottom: 6px;
    display: block
  }

  input[type=text],
  input[type=tel] {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #e2e2e2;
    border-radius: 10px
  }

  .btn-primary {
    display: block;
    width: 100%;
    border: 0;
    border-radius: 12px;
    padding: 14px 18px;
    font-weight: 800;
    background: #f97316;
    color: #fff;
    cursor: pointer
  }

  /* Summary */
  .summary-header {
    display: grid;
    grid-template-columns: 1fr auto auto;
    gap: 20px;
    font-weight: 800;
    padding: 8px 0;
    border-bottom: 2px solid #ddd;
    margin-bottom: 6px;
  }

  .sum-item {
    display: grid;
    grid-template-columns: 1fr auto auto;
    gap: 20px;
    padding: 10px 0;
    border-bottom: 1px solid #f1f1f1;
  }

  .summary-header div:nth-child(2),
  .summary-header div:nth-child(3),
  .sum-item div:nth-child(2),
  .sum-item div:nth-child(3) {
    text-align: center;
    white-space: nowrap;
  }

  .divider {
    border-top: 1px solid #ddd;
    margin: 14px 0
  }

  .tot {
    display: flex;
    justify-content: space-between;
    margin-top: 6px;
    font-weight: 800
  }

  .muted {
    color: #666
  }
</style>

<!-- Checkout -->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="form-weight-bold">Check Out</h2>
    <hr class="mx-auto" />
  </div>
  
  <div class="mx-auto container wrap">
    <form id="checkout-form" method="POST" action="server/place_order.php">
      <p class="text-center" style="color: red;">
        <?php if (isset($_GET['message'])) {
          echo htmlspecialchars($_GET['message']);
        } ?>
        <?php if (isset($_GET['message'])) { ?>
          <a href="login.php" class="btn btn-primary">Login</a>
          <?php } ?>
        </p>
        
      
      <div class="form-group checkout-small-element grid">
        <div class="head">Collection</div>
        <h4>Click & Collect at:</h4>
        <label for="checkout-name">Address: </label>
        <input readonly type="text" class="form-control" placeholder="55 Wellesley Street East, Auckland Central, Auckland 1010"  />
      </div>

      <h4>Enter details of person collecting this order:</h4>
      <div class="form-group checkout-small-element">
        <label for="checkout-name">Full Name: </label>
        <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required />
      </div>

      <!-- <div class="form-group checkout-small-element">
        <label for="checkout-email">Email</label>
        <input
          type="email"
          class="form-control"
          id="checkout-email"
          name="email"
          placeholder="Email"
          required
        />
      </div> -->

      <div class="form-group checkout-small-element">
        <label for="checkout-phone">Phone Number: </label>
        <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required />
      </div>

      <!-- <div class="form-group checkout-small-element">
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
      </div> -->

      <div class="form-group checkout-btn-container d-flex align-items-center justify-content-between">
        <!-- <p class="mb-0">
          <strong>Total amount:</strong>
          $ <//?= number_format($_SESSION['total'] ?? 0, 2) ?>
        </p> -->

        <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order" />
      </div>
    </form>
    
    <div class="wrap">
  
      <div class="grid">
        <!-- Collection form -->
  
  
        <!-- Order Summary -->
        <div class="card">
          <div class="head">Order Summary</div>
          <div class="body">
            <div class="summary-header">
              <div>Product</div>
              <div class="muted">Quantity</div>
              <div class="muted">Price</div>
            </div>
  
            <?php foreach ($order['items'] as $it): ?>
              <div class="sum-item">
                <div><?= htmlspecialchars($it['name'] ?? 'Item') ?></div>
                <div class="muted">x<?= (int) ($it['quantity'] ?? 0) ?></div>
                <div>$ <?= number_format((float) ($it['subtotal'] ?? 0), 2) ?></div>
              </div>
            <?php endforeach; ?>
  
            <div class="divider"></div>
  
            <div class="tot">
              <span class="muted">Promo code</span>
              <span class="muted">- $ <?= number_format((float) ($order['discount'] ?? 0), 2) ?></span>
            </div>
            <div class="tot">
              <span>Total Amount</span>
              <span>$ <?= number_format($amount, 2) ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>


<?php include('layouts/footer.php'); ?>