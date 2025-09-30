<?php
// thank_you.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/layouts/header.php';

/* Helpers */
function to_float($v) {
  if (is_numeric($v)) return (float)$v;
  $clean = preg_replace('/[^\d.]/', '', (string)$v);
  return $clean === '' ? 0.0 : (float)$clean;
}

/* Get recent order snapshot */
$order = $_SESSION['recent_order'] ?? $_SESSION['last_order'] ?? null;

if (!$order) {
  echo '<section class="my-5 py-5"><div class="container text-center mt-3 pt-5"><h2>Thank you!</h2><hr class="mx-auto"/><p>No recent order found.</p></div></section>';
  require_once __DIR__ . '/layouts/footer.php';
  exit;
}

/* Normalize items */
$norm = [];
$subtotal = 0.0;
foreach ($order['items'] as $it) {
  $name  = $it['name'] ?? $it['product_name'] ?? 'Item';
  $qty   = isset($it['quantity']) ? (int)$it['quantity'] : (int)($it['product_quantity'] ?? 0);
  if (isset($it['subtotal'])) {
    $line = to_float($it['subtotal']);
  } else {
    $price = isset($it['product_price']) ? to_float($it['product_price']) : to_float($it['price'] ?? 0);
    $line  = $qty * $price;
  }
  $subtotal += $line;
  $norm[] = ['name' => $name, 'quantity' => $qty, 'subtotal' => $line];
}
$order['items']    = $norm;
$order['subtotal'] = $order['subtotal'] ?? $subtotal;
$order['discount'] = $order['discount'] ?? (float)($_SESSION['promo_discount'] ?? 0.0);
$order['total']    = $order['total'] ?? max(0, $order['subtotal'] - $order['discount']);

$prettyId      = sprintf('USH%04d', (int)($order['order_id'] ?? 0));
$pickupAddress = "55 Wellesley Street East, Auckland Central, Auckland 1010";
$pickupTime    = date('d-m-Y H:i:s');
?>
<style>
  .wrap{max-width:1100px;margin:100px auto 40px;padding:0 16px}
  .big{font-size:44px;font-weight:800;text-align:center;margin:0 0 8px}
  .order-id{text-align:center;font-size:20px;margin-bottom:24px;color:#333}
  .grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}
  @media(max-width:900px){.grid{grid-template-columns:1fr}}

  /* Order Summary styles */
  .card{background:#fff;border:1px solid #eee;border-radius:16px;box-shadow:0 6px 18px rgba(0,0,0,.06);overflow:hidden}
  .head{background:#f97316;color:#fff;padding:16px 20px;font-size:22px;font-weight:800}
  .body{padding:18px;background:#fff}

  .summary-header{
    display:grid;grid-template-columns:1fr auto auto;gap:20px;
    font-weight:800;padding:8px 0;border-bottom:2px solid #ddd;margin-bottom:6px
  }
  .sum-item{
    display:grid;grid-template-columns:1fr auto auto;gap:20px;
    padding:10px 0;border-bottom:1px solid #f1f1f1
  }
  .summary-header div:nth-child(2), .summary-header div:nth-child(3),
  .sum-item div:nth-child(2), .sum-item div:nth-child(3){text-align:center;white-space:nowrap}
  .divider{border-top:1px solid #ddd;margin:14px 0}
  .tot{display:flex;justify-content:space-between;margin-top:6px;font-weight:800}
  .muted{color:#666}

  /* Minimal pickup block */
  .pickup-block{max-width:600px;padding:0 16px;text-align:left}
  .pickup-block h2{font-size:24px;font-weight:700;margin-bottom:10px}
  .pickup-block p{margin:6px 0}
  .pickup-block .btn{
    display:inline-block;margin-top:14px;background:#f97316;
    color:#fff;padding:10px 16px;border-radius:6px;text-decoration:none
  }
</style>

<div class="wrap">
  <div class="big">Thank you for your Order!</div>
  <div class="order-id">Order ID: #<?= htmlspecialchars($prettyId) ?></div>

  <div class="grid">
    <!-- Minimal Pick up section -->
    <div class="pickup-block">
      <h2>Pick up</h2>
      <p>Please pick up your order at:<br><?= htmlspecialchars($pickupAddress) ?></p>
      <p>Time: <?= htmlspecialchars($pickupTime) ?></p>
      <a href="index.php" class="btn">Return to home</a>
    </div>

    <!-- Order Summary -->
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
          <span>$ <?= number_format((float)$order['total'], 2) ?></span>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
