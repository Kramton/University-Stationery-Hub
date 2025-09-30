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

include('layouts/header.php');

/* ------- Helpers ------- */
function to_float($v){
  if (is_numeric($v)) return (float)$v;
  $clean = preg_replace('/[^\d.]/', '', (string)$v);
  return $clean === '' ? 0.0 : (float)$clean;
}

/* ------- Build / normalize order snapshot ------- */
$items = [];
$subtotal = 0.0;
foreach ($_SESSION['cart'] as $it) {
  $name  = $it['product_name'] ?? $it['name'] ?? 'Item';
  $qty   = isset($it['product_quantity']) ? (int)$it['product_quantity'] : (int)($it['quantity'] ?? 0);
  $price = isset($it['product_price']) ? to_float($it['product_price']) : to_float($it['price'] ?? 0);
  $line  = $qty * $price;
  $subtotal += $line;
  $items[] = ['name' => $name, 'quantity' => $qty, 'subtotal' => $line];
}
$discount = (float)($_SESSION['promo_discount'] ?? 0.0);
$total    = max(0, $subtotal - $discount);
$order = [
  'order_id'  => $_SESSION['order_id'] ?? 0,
  'items'     => $items,
  'subtotal'  => $subtotal,
  'discount'  => $discount,
  'total'     => $total,
];

$amount   = (float)$order['total'];
$order_id = (int)($order['order_id'] ?? ($_SESSION['order_id'] ?? 0));

// Make sure place_order.php will have the total
$_SESSION['total'] = $amount;
?>
<style>
  /* Push down so title isn’t blocked by fixed header */
  .wrap{max-width:1100px;margin:120px auto 40px;padding:0 16px}
  .title{font-size:44px;font-weight:800;text-align:center;margin:10px 0 24px}

  .grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}
  @media(max-width:900px){.grid{grid-template-columns:1fr}}

  .card{background:#fff;border:1px solid #eee;border-radius:16px;box-shadow:0 6px 18px rgba(0,0,0,.06);overflow:hidden}
  .head{background:#f97316;color:#fff;padding:16px 20px;font-size:24px;font-weight:800}
  .body{padding:18px;background:#fff}

  /* Form */
  .row{margin-bottom:14px}
  label{font-weight:700;margin-bottom:6px;display:block}
  input[type=text],input[type=tel]{width:100%;padding:12px 14px;border:1px solid #e2e2e2;border-radius:10px}
  .btn-primary{display:block;width:100%;border:0;border-radius:12px;padding:14px 18px;font-weight:800;background:#f97316;color:#fff;cursor:pointer}

  /* Summary */
  .summary-header{display:grid;grid-template-columns:1fr auto auto;gap:20px;font-weight:800;padding:8px 0;border-bottom:2px solid #ddd;margin-bottom:6px}
  .sum-item{display:grid;grid-template-columns:1fr auto auto;gap:20px;padding:10px 0;border-bottom:1px solid #f1f1f1}
  .summary-header div:nth-child(2),.summary-header div:nth-child(3),
  .sum-item div:nth-child(2),.sum-item div:nth-child(3){text-align:center;white-space:nowrap}
  .divider{border-top:1px solid #ddd;margin:14px 0}
  .tot{display:flex;justify-content:space-between;margin-top:6px;font-weight:800}
  .muted{color:#666}
  .flash{color:#c52;font-weight:700;margin-bottom:10px;text-align:center}
</style>

<div class="wrap">
  <div class="title">Checkout</div>

  <?php if (isset($_GET['message']) && $_GET['message']): ?>
    <p class="flash">
      <?= htmlspecialchars($_GET['message']) ?>
      <?php if (stripos($_GET['message'], 'log in') !== false || stripos($_GET['message'], 'register') !== false): ?>
        <a href="login.php" class="btn-primary" style="max-width:200px;margin:10px auto 0;">Login</a>
      <?php endif; ?>
    </p>
  <?php endif; ?>

  <div class="grid">
    
<!-- Collection form card (LEFT) -->
<div class="card">
  <div class="head">Collection</div>
  <div class="body">
    <form id="checkout-form" method="POST" action="server/place_order.php">
      <p><strong>Click &amp; Collect at:</strong></p>

      <!-- Editable pickup address (prefilled, but user can change it) -->
      <div class="row">
        <label for="pickup-address">Address</label>
        <input
          type="text"
          id="pickup-address"
          name="address"
          value="55 Wellesley Street East, Auckland Central, Auckland 1010"
          placeholder="Enter pickup address"
          required
        />
      </div>

      <p>Enter details of person collecting this order:</p>

      <div class="row">
        <label for="checkout-name">Full Name</label>
        <input type="text" id="checkout-name" name="name" placeholder="John Doe" required />
      </div>

      <div class="row">
        <label for="checkout-phone">Phone Number</label>
        <input type="tel" id="checkout-phone" name="phone" placeholder="123 456 7890" required />
      </div>

      <div class="row">
        <button type="submit" class="btn-primary" name="place_order">Place Order</button>
      </div>
    </form>
  </div>
</div>



    <!-- Order Summary card (RIGHT) -->
    <div class="card">
      <div class="head">Order Summary</div>
      <div class="body">
        <div class="summary-header">
          <div>Product</div><div class="muted">Quantity</div><div class="muted">Price</div>
        </div>

        <?php foreach ($order['items'] as $it): ?>
          <div class="sum-item">
            <div><?= htmlspecialchars($it['name'] ?? 'Item') ?></div>
            <div class="muted">x<?= (int)($it['quantity'] ?? 0) ?></div>
            <div>$ <?= number_format((float)($it['subtotal'] ?? 0), 2) ?></div>
          </div>
        <?php endforeach; ?>

        <div class="divider"></div>

        <div class="tot">
          <span class="muted">Promo code</span>
          <span class="muted">- $ <?= number_format((float)($order['discount'] ?? 0), 2) ?></span>
        </div>
        <div class="tot">
          <span>Total Amount</span>
          <span>$ <?= number_format($amount, 2) ?></span>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('layouts/footer.php'); ?>
