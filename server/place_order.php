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

// Helper to coerce prices safely
function to_float($v) {
  if (is_numeric($v)) return (float)$v;
  $clean = preg_replace('/[^\d.]/', '', (string)$v);
  return $clean === '' ? 0.0 : (float)$clean;
}

if (isset($_POST['place_order'])) {

  // Basic form fields
  $name    = trim($_POST['name']    ?? '');
  $phone   = trim($_POST['phone']   ?? '');
  $address = trim($_POST['address'] ?? '');

  // Email and City are no longer required
  $email   = trim($_POST['email']   ?? '');
  $city    = trim($_POST['city']    ?? '');

  if ($name === '' || $phone === '' || $address === '') {
    header('Location: ../checkout.php?message=Please+fill+all+fields');
    exit;
  }

  // Must have a cart
  if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    header('Location: ../cart.php?message=Your+cart+is+empty');
    exit;
  }

  // Recompute total from the session cart
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

  // Apply promo discount if any
  $discount = isset($_SESSION['promo_discount']) ? (float)$_SESSION['promo_discount'] : 0.0;
  $order_cost = max(0, $computed_total - $discount);

  // Save totals in session
  $_SESSION['subtotal'] = $computed_total;
  $_SESSION['total']    = $order_cost;

  $order_status = 'not paid';
  $user_id      = (int)($_SESSION['user_id'] ?? 0);
  $order_date   = date('Y-m-d H:i:s');

  // Start transaction
  $conn->begin_transaction();
  try {
    // Insert order (removed NOT NULL requirement for email/city)
    $stmt = $conn->prepare(
      "INSERT INTO orders
        (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
       VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
      'dsissss',
      $order_cost,      // d
      $order_status,    // s
      $user_id,         // i
      $phone,           // s
      $city,            // s (can be empty string)
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
      $stmt1->bind_param(
        'iissdiis',
        $order_id,
        $it['product_id'],
        $it['product_name'],
        $it['product_image'],
        $it['product_price'],
        $it['product_quantity'],
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

    // Save snapshot for thank_you/payment page
    $_SESSION['order_id']   = $order_id;
    $_SESSION['last_order'] = [
      'order_id'   => $order_id,
      'customer'   => compact('name','phone','address'),
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
    header('Location: ../cart.php?message=Could+not+place+order');
    exit;
  }
}

// Fallback if accessed without POST
header('Location: ../cart.php');
exit;
