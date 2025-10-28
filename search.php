<?php


     session_start();
   
     require_once __DIR__ . '/server/connection.php';

    $q = isset($_GET['q']) ? trim($_GET['q']) : '';
  if ($q === '') 
  
  {
  header('Location: shop.php');
  exit;
  }

 
   $stmt = $conn->prepare("SELECT product_id FROM products WHERE LOWER(product_name) = LOWER(?) LIMIT 1");
    $stmt->bind_param('s', $q);
    $stmt->execute();
   $res = $stmt->get_result();
   if ($row = $res->fetch_assoc()) 
   
   
   {
  header('Location: single_product.php?product_id='.(int)$row['product_id']);
  exit;
}


