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

  
