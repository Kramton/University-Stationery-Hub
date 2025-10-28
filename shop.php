<?php include('layouts/header.php') ?>
<link rel="stylesheet" href="assets/css/style.css?v=6">

<?php

include('server/connection.php');

//use search section
if (isset($_POST['search'])) {

  if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
     $page_no = $_GET['page_no'];
  } else {
     $page_no = 1;
  }


  // price filter 
    $category = $_POST['category'];
    $price    = (int)$_POST['price'];
    $isAll    = ($category === '' || strtolower($category) === 'all'); 
   

  // Return number of products
   if ($isAll) {
  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products WHERE product_price <= ?");
    $stmt1->bind_param("i", $price);} else {
      $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products WHERE product_category = ? AND product_price <= ?");
    $stmt1->bind_param("si", $category, $price);} 

  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();


  $total_records_per_page = 8;

  $offset = ($page_no - 1) * $total_records_per_page;

  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $adjacents = 2;

  $total_no_of_pages = ceil($total_records / $total_records_per_page);

  if ($isAll) {
  $stmt2 = $conn->prepare("SELECT *, market_price FROM products WHERE product_price <= ? LIMIT $offset, $total_records_per_page");
    $stmt2->bind_param("i", $price); } 
    else {
  $stmt2 = $conn->prepare("SELECT *, market_price FROM products WHERE product_category = ? AND product_price <= ? LIMIT $offset, $total_records_per_page");
    $stmt2->bind_param("si", $category, $price);
    }
  
     $stmt2->execute();
     $products = $stmt2->get_result();




      } 
       elseif (isset($_GET['cat']) && $_GET['cat'] !== '')
   
   {

     if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
     $page_no = (int)$_GET['page_no'];
      } else 
    {
         $page_no = 1;
    }

  $category = $_GET['cat'];
  $price    = 200; 

  // Count for pagination
  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records
                           FROM products
                           WHERE product_category = ? AND product_price <= ?");
  $stmt1->bind_param("si", $category, $price);
  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();

  $total_records_per_page = 8;
  $offset = ($page_no - 1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;
  $adjacents = 2;
  $total_no_of_pages = ceil($total_records / $total_records_per_page);


$stmt2 = $conn->prepare("SELECT *, market_price FROM products
                           WHERE product_category = ? AND product_price <= ?
                           LIMIT $offset, $total_records_per_page");
  $stmt2->bind_param("si", $category, $price);
  $stmt2->execute();
  $products = $stmt2->get_result();

  $ui_price_value = $price;
  $ui_category    = $category;
    
    

    } else{

     if (isset($_GET['page_no']) && $_GET['page_no'] != "")
   {
   
    $page_no = $_GET['page_no'];
     } else {
   
        $page_no = 1;
    }

