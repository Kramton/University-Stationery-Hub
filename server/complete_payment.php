<?php
// server/complete_payment.php
session_start();
date_default_timezone_set('Pacific/Auckland');
include('connection.php');

if (!isset($_POST['order_id'], $_POST['card_name'], $_POST['card_number'], $_POST['card_exp'], $_POST['card_cvv'])) {
    header("Location: ../payment.php?message=Missing+payment+details");
    exit;
}

$order_id = (int)$_POST['order_id'];
$user_id  = $_SESSION['user_id'] ?? 0;
$payment_date = date('Y-m-d H:i:s');

// Simulate a transaction id (in production you’d get this from a payment gateway)
$transaction_id = 'SIM-' . strtoupper(bin2hex(random_bytes(6)));

// Mark order as paid
$stmt = $conn->prepare("UPDATE orders SET order_status = 'paid' WHERE order_id = ?");
$stmt->bind_param('i', $order_id);
$stmt->execute();
$stmt->close();

// Store payment info
$stmt1 = $conn->prepare("INSERT INTO payments (order_id, user_id, transaction_id, payment_date) VALUES (?,?,?,?)");
$stmt1->bind_param('iiss', $order_id, $user_id, $transaction_id, $payment_date);
$stmt1->execute();
$stmt1->close();

// Save snapshot for thank you page
if (isset($_SESSION['last_order']) && $_SESSION['last_order']['order_id'] == $order_id) {
    $_SESSION['recent_order'] = $_SESSION['last_order'];
    $_SESSION['recent_order']['transaction_id'] = $transaction_id;
}

// Clear the cart
unset($_SESSION['cart'], $_SESSION['subtotal'], $_SESSION['total'], $_SESSION['promo_code'], $_SESSION['promo_discount']);

// Redirect to thank you page
header("Location: ../thank_you.php");
exit;
