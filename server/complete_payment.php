<?php
// server/complete_payment.php
session_start();
date_default_timezone_set('Pacific/Auckland');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (function_exists('mysqli_report')) {
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
}

// connection
require_once __DIR__ . '/connection.php';

// 1) 
$order_id    = isset($_POST['order_id'])   ? (int)$_POST['order_id'] : 0;
$card_name   = isset($_POST['card_name'])  ? trim($_POST['card_name']) : '';
$card_number = isset($_POST['card_number'])? preg_replace('/\D+/', '', $_POST['card_number']) : ''; 
$card_exp    = isset($_POST['card_exp'])   ? trim($_POST['card_exp']) : ''; 
$card_cvv    = isset($_POST['card_cvv'])   ? preg_replace('/\D+/', '', $_POST['card_cvv']) : '';   

if ($order_id <= 0 || $card_name === '' || $card_number === '' || $card_cvv === '') {
  header("Location: ../payment.php?message=" . urlencode("Missing payment details"));
  exit;
}

$user_id      = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$payment_date = date('Y-m-d H:i:s');

// Simulate a transaction id (in production you’d get this from a payment gateway)
$transaction_id = 'SIM-' . strtoupper(bin2hex(random_bytes(6)));

// Mark order as closed
$stmt = $conn->prepare("UPDATE orders SET order_status = 'Closed' WHERE order_id = ?");
$stmt->bind_param('i', $order_id);
$stmt->execute();
$stmt->close();

// Store payment info
$stmt1 = $conn->prepare("INSERT INTO payments (order_id, user_id, transaction_id, payment_date) VALUES (?,?,?,?)");
$stmt1->bind_param('iiss', $order_id, $user_id, $transaction_id, $payment_date);
$stmt1->execute();
$stmt1->close();



// encrypt card number & CVV -> base64 
$demo_key = "12345678901234567890123456789012"; // 32 chars (AES-256-CBC)
$demo_iv  = "1234567890123456";                 // 16 chars IV

$card_last4       = substr($card_number, -4);
$enc_card_number  = base64_encode(openssl_encrypt($card_number, 'AES-256-CBC', $demo_key, OPENSSL_RAW_DATA, $demo_iv));
$enc_card_cvc     = base64_encode(openssl_encrypt($card_cvv,   'AES-256-CBC', $demo_key, OPENSSL_RAW_DATA, $demo_iv));
$nonce_b64        = base64_encode($demo_iv);

//payment_info
$stmt2 = $conn->prepare("
  INSERT INTO payment_info
    (order_id, user_id, card_name, card_last4, enc_card_number, enc_card_cvc, nonce_card, nonce_cvc)
  VALUES (?,?,?,?,?,?,?,?)
");
$stmt2->bind_param(
  'iissssss',
  $order_id,
  $user_id,
  $card_name,
  $card_last4,
  $enc_card_number,
  $enc_card_cvc,
  $nonce_b64,
  $nonce_b64
);
$stmt2->execute();
$stmt2->close();

// After a successful payment, log the promo code usage for this user.
if (isset($_SESSION['promo_data'])) {
    $promo_code_id = $_SESSION['promo_data']['id'];

    // Prepare and execute the insert statement to log the usage
    $stmt_log_usage = $conn->prepare("INSERT INTO user_promo_code_usage (user_id, promo_code_id) VALUES (?, ?)");
    $stmt_log_usage->bind_param('ii', $user_id, $promo_code_id);
    $stmt_log_usage->execute();
    $stmt_log_usage->close();
}


// Decrement product stock for each item in the order
$stmt_items = $conn->prepare("SELECT product_id, product_quantity FROM order_items WHERE order_id = ?");
$stmt_items->bind_param('i', $order_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();
while ($item = $result_items->fetch_assoc()) {
  $product_id = (int)$item['product_id'];
  $qty = (int)$item['product_quantity'];
  $stmt_update = $conn->prepare("UPDATE products SET product_stock = GREATEST(product_stock - ?, 0) WHERE product_id = ?");
  $stmt_update->bind_param('ii', $qty, $product_id);
  $stmt_update->execute();
  $stmt_update->close();
}
$stmt_items->close();

// Save snapshot for thank you page
if (isset($_SESSION['last_order']) && $_SESSION['last_order']['order_id'] == $order_id) {
  $_SESSION['recent_order'] = $_SESSION['last_order'];
  $_SESSION['recent_order']['transaction_id'] = $transaction_id;
}

// Clear the cart & promo code data from the session
unset($_SESSION['cart'], $_SESSION['subtotal'], $_SESSION['total'], $_SESSION['promo_data'], $_SESSION['promo_discount']);

// Redirect to thank you page
header("Location: ../thank_you.php");
exit;