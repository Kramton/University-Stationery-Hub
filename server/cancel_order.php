<?php
session_start();
include('connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: ../login.php');
    exit;
}

if (isset($_POST['cancel_order_btn']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $user_id = $_SESSION['user_id'];

    // Check if order belongs to user and is not paid
    $stmt = $conn->prepare("SELECT order_status FROM orders WHERE order_id = ? AND user_id = ? LIMIT 1");
    $stmt->bind_param('ii', $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if ($row['order_status'] == 'not paid') {
            // Delete order items first
            $stmt_items = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
            $stmt_items->bind_param('i', $order_id);
            $stmt_items->execute();
            // Delete order
            $stmt_order = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
            $stmt_order->bind_param('i', $order_id);
            $stmt_order->execute();
            $_SESSION['message'] = 'Order cancelled successfully.';
        } else {
            $_SESSION['error'] = 'Order cannot be cancelled.';
        }
    } else {
        $_SESSION['error'] = 'Order not found.';
    }
    header('location: ../my_orders.php');
    exit;
} else {
    header('location: ../my_orders.php');
    exit;
}
?>
