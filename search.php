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

$stmt->close();

    $categories = [
      'Writing Essentials',
      'Notebooks & Paper',
       'Desk Accessories',
       'Creative Supplies',
       'Study Tools'
];

  $contains = function(string $haystack, string $needle)  
  
  {
  return stripos($haystack, $needle) !== false;
   

 };

// direct match to category by name/partial
  $catHit = null;

   
    foreach ($categories as $c) 
    
    {
  if (strcasecmp($q, $c) === 0 || $contains($c, $q) || $contains($q, $c)) 
   {
     $catHit = $c;
     break;
   }
}

if ($catHit === null) 
{
  // look up products that partially match the query, then choose the most common category
    $like = '%'.$q.'%';
     $stmt = $conn->prepare("
    SELECT product_category
    FROM products
    WHERE product_name LIKE ? OR product_description LIKE ?
    LIMIT 100
  ");

   
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $res = $stmt->get_result();

    $tally = [];
  while ($r = $res->fetch_assoc()) 
  
   {
    $c = $r['product_category'];
    $tally[$c] = ($tally[$c] ?? 0) + 1;
   }
  
  
    arsort($tally);
    $catHit = !empty($tally) ? array_key_first($tally) : null;
    $stmt->close();
}

   if ($catHit) 
   {


  header('Location: shop.php?cat='.urlencode($catHit));


     } else {
     header('Location: shop.php?q='.urlencode($q));
    }
  exit;
