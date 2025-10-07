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

/* Load order snapshot produced by place_order.php */
$order = $_SESSION['recent_order'] ?? $_SESSION['last_order'] ?? null;

if (!$order) {
  echo '<section class="my-5 py-5"><div class="container text-center mt-3 pt-5"><h2>Thank you!</h2><hr class="mx-auto"/><p>No recent order found.</p></div></section>';
  require_once __DIR__ . '/layouts/footer.php';
  exit;
}

/* Normalize items for display */
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

/* Pull customer details saved in place_order.php */
$customer       = $order['customer'] ?? [];
$pickupAddress  = $customer['address'] ?? 'Not provided';
// Prefer pickup_name from DB if present
$pickupName = $order['pickup_name'] ?? ($customer['name'] ?? '');

/* Order ID + pickup time */
$prettyId   = sprintf('USH%04d', (int)($order['order_id'] ?? 0));
$pickupTime = isset($order['order_date'])
  ? date('d-m-Y H:i:s', strtotime($order['order_date']))
  : date('d-m-Y H:i:s');
?>
<style>
  /* Layout */
  .wrap{max-width:1100px;margin:100px auto 50px;padding:0 16px}
  .title{font-size:42px;font-weight:800;text-align:center;margin:0}
  .order-id{text-align:center;margin:6px 0 28px;font-size:18px}
  .grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}
  @media(max-width:900px){.grid{grid-template-columns:1fr}}

  /* Simple Pick up block (left) */
  .pickup{
    padding:6px 6px 6px 0;   /* small left spacing to mimic your screenshot */
  }
  .pickup h2{
    font-size:22px;
    font-weight:700;
    margin:0 0 10px;
  }
  .pickup p{margin:6px 0;font-size:15px;color:#222}
  .pickup .btn{
    display:inline-block;margin-top:10px;background:#f97316;color:#fff;
    padding:10px 16px;border-radius:6px;text-decoration:none;font-weight:600
  }

  /* Order Summary card (right) – keep your card look */
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
</style>

<div class="wrap">
  <h1 class="title">Thank you for your Order!</h1>
  <div class="order-id">Order ID: #<?= htmlspecialchars($prettyId) ?></div>

  <div class="grid">
    <!-- LEFT: simple Pick up block -->
    <div class="pickup">
      <h2>Pick up</h2>
      <p>Please pick up your order at:<br><?= htmlspecialchars($pickupAddress) ?></p>
        <?php if (!empty($pickupName)): ?>
          <p>To be picked up by: <strong><?= htmlspecialchars($pickupName) ?></strong></p>
        <?php endif; ?>
      <?php if (!empty($customer['phone'])): ?>
        <p>Contact number: <strong><?= htmlspecialchars($customer['phone']) ?></strong></p>
      <?php endif; ?>
      <p>Time: <?= htmlspecialchars($pickupTime) ?></p>
      <a href="index.php" class="btn">Return to home</a>
    </div>

    <!-- RIGHT: Order Summary card -->
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
