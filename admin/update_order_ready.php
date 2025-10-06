<?php
// update_order_ready.php
// Updates the ready_for_pickup status for an order via AJAX

require_once '../server/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $ready = isset($_POST['ready']) ? intval($_POST['ready']) : 0;

    if ($order_id > 0) {
        $stmt = $conn->prepare("UPDATE orders SET ready_for_pickup = ? WHERE order_id = ?");
        $stmt->bind_param('ii', $ready, $order_id);
        $success = $stmt->execute();
        $stmt->close();
        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'DB error']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid order id']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
