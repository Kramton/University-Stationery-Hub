<?php
include('../server/connection.php');

if (isset($_POST['order_id'], $_POST['order_status'])) {
    $order_id = (int)$_POST['order_id'];
    $order_status = ($_POST['order_status'] === 'Open') ? 'Open' : 'Closed';
    $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id=?");
    $stmt->bind_param('si', $order_status, $order_id);
    $stmt->execute();
    $stmt->close();
    echo 'success';
    exit;
}
echo 'error';
exit;
