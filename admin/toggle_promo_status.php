<?php
session_start();
include('../server/connection.php');

header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in'])) {
  echo json_encode(['success' => false, 'message' => 'Not authenticated']);
  exit();
}

if (isset($_POST['promo_id']) && isset($_POST['is_active'])) {
  $promo_id = intval($_POST['promo_id']);
  $is_active = intval($_POST['is_active']);
  
  $stmt = $conn->prepare("UPDATE promo_codes SET is_active = ? WHERE id = ?");
  $stmt->bind_param("ii", $is_active, $promo_id);
  
  if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Database update failed: ' . $stmt->error]);
  }
  $stmt->close();
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
}
?>