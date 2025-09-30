<?php
// server/place_order.php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
date_default_timezone_set('Pacific/Auckland');

require_once __DIR__ . '/connection.php';

// Must be logged in
if (!isset($_SESSION['logged_in'])) {
  header('Location: ../checkout.php?message=Please+Log+in+%2F+Register+to+place+an+order!');
  exit;
}

// Helper to coerce prices safely (handles "$2.00", "2.00 NZD")
function to_float($v) {
  if (is_numeric($v)) return (float)$v;
  $clean = preg_replace('/[^\d.]/', '', (string)$v);
  return $clean === '' ? 0.0 : (float)$clean;
}

if (isset($_POST['place_order'])) {

  // Basic form fields
  $name    = trim($_POST['name']    ?? '');
  $email   = trim($_POST['email']   ?? '');
  $phone   = trim($_POST['phone']   ?? '');
  $city    = trim($_POST['city']    ?? '');
  $address = trim($_POST['address'] ?? '');

  if ($name === '' || $email === '' || $phone === '' || $city === '' || $address === '') {
    header('Location: ../checkout.php?message=Please+fill+all+fields');
    exit;
  }

  // Must have a cart
  if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    header('Location: ../cart.php?message=Your+cart+is+empty');
    exit;
  }

  // Recompute total from the session cart (never trust client/session totals blindly)
  $computed_total = 0.0;
  $items_snapshot = [];

  foreach ($_SESSION['cart'] as $item) {
    $qty = isset($item['product_quantity'])
      ? (int)$item['product_quantity']
      : (isset($item['quantity']) ? (int)$item['quantity'] : (isset($item['qty']) ? (int)$item['qty'] : 0));

    $price = 0.0;
    if (isset($item['product_price'])) $price = to_float($item['product_price']);
    elseif (isset($item['price']))     $price = to_float($item['price']);

    $line_total = $qty * $price;
    $computed_total += $line_total;

    $items_snapshot[] = [
      'product_id'       => (int)($item['product_id'] ?? 0),
      'product_name'     => (string)($item['product_name'] ?? 'Item'),
      'product_image'    => (string)($item['product_image'] ?? ''),
      'product_price'    => $price,
      'product_quantity' => $qty,
      'subtotal'         => $line_total,
    ];
  }

  // Apply any promo discount already stored (optional)
  $discount = isset($_SESSION['promo_discount']) ? (float)$_SESSION['promo_discount'] : 0.0;
  $order_cost = max(0, $computed_total - $discount);

  // Keep totals in session for display, but DB uses $order_cost
  $_SESSION['subtotal'] = $computed_total;
  $_SESSION['total']    = $order_cost;

  $order_status = 'not paid';
  $user_id      = (int)($_SESSION['user_id'] ?? 0);
  $order_date   = date('Y-m-d H:i:s');

  // Start transaction
  $conn->begin_transaction();
  try {
    // Insert order
    $stmt = $conn->prepare(
      "INSERT INTO orders
        (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
       VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    // d = double (money), s = string, i = int
    $stmt->bind_param('dsissss',
      $order_cost,      // d
      $order_status,    // s
      $user_id,         // i
      $phone,           // s  (keep as string to preserve leading zeros)
      $city,            // s
      $address,         // s
      $order_date       // s
    );
    if (!$stmt->execute()) {
      throw new Exception('Failed to insert order.');
    }
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Insert order items
    $stmt1 = $conn->prepare(
      "INSERT INTO order_items
        (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    foreach ($items_snapshot as $it) {
      $pid   = $it['product_id'];
      $pname = $it['product_name'];
      $pimg  = $it['product_image'];
      $pprice= $it['product_price'];   // decimal
      $pqty  = $it['product_quantity'];

      // i, i, s, s, d, i, i, s
      $stmt1->bind_param('iissdiis',
        $order_id,
        $pid,
        $pname,
        $pimg,
        $pprice,
        $pqty,
        $user_id,
        $order_date
      );
      if (!$stmt1->execute()) {
        throw new Exception('Failed to insert order item.');
      }
    }
    $stmt1->close();

    

    // Commit all DB work
    $conn->commit();

    // Save a snapshot for the payment/thank-you page
    $_SESSION['order_id']   = $order_id;
    $_SESSION['last_order'] = [
      'order_id'   => $order_id,
      'customer'   => compact('name','email','phone','city','address'),
      'items'      => $items_snapshot,
      'subtotal'   => $computed_total,
      'discount'   => $discount,
      'total'      => $order_cost,
      'order_date' => $order_date,
    ];

    

    header('Location: ../payment.php?order_status=Order+placed+successfully');
    exit;

  } catch (Throwable $e) {
    $conn->rollback();
    // Log $e->getMessage() in real apps
    header('Location: ../cart.php?message=Could+not+place+order');
    exit;
  }
}

// Fallback if accessed without POST
header('Location: ../cart.php');
exit;
