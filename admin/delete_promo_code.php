<?php
session_start();
include('../server/connection.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

if (isset($_GET['promo_code_id'])) {
    $promo_code_id = $_GET['promo_code_id'];

    $stmt = $conn->prepare("DELETE FROM promo_codes WHERE id = ?");
    $stmt->bind_param('i', $promo_code_id);

    if ($stmt->execute()) {
        header('location: promo_codes.php?deleted_successfully=Promo code has been deleted successfully!');
    } else {
        header('location: promo_codes.php?deleted_failure=Could not delete promo code.');
    }
    $stmt->close();
    exit();
} else {
    header('location: promo_codes.php');
    exit();
}
?>