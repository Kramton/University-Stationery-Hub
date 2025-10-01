<?php include('layouts/header.php'); ?>
<link rel="stylesheet" href="/University-Stationary-Hub/assets/css/style.css?v=5">

<?php 
include('server/connection.php');

if(isset($_GET['product_id'])){
  $product_id = (int)$_GET['product_id'];
  $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $product = $stmt->get_result();
} else {
  header('location: index.php');
  exit;
}
?>


<section class="container single-product my-5 pt-5">
  <div class="row mt-5">
    <?php while($row = $product->fetch_assoc()): 
      $price = (float)$row['product_price'];
     // $promoPrice  = isset($row['product_special_offer']) && $row['product_special_offer'] !== '' ? (float)$row['product_promo_price'] : null;
      $isNew = isset($row['product_is_new']) ? (int)$row['product_is_new'] : 0;
      $stock = isset($row['product_stock']) && $row['product_stock'] !== '' ? (int)$row['product_stock'] : 5; // fallback 5
      $discountPercent = isset($row['product_special_offer']) ? (int)$row['product_special_offer'] : 0;
      // compute promo price from % 
        $promoPrice = ($discountPercent > 0)
                  ? round($price * (100 - $discountPercent) / 100, 2)
                  : null;

  // how much save
  $savings = ($promoPrice !== null) ? max(0, round($price - $promoPrice, 2)) : 0;
    ?>

    
    <!-- lleft  gallery -->
    <div class="col-lg-5 col-md-6 col-sm-12">
      <div class="img-wrap">
        <?php if ($isNew): ?>
          <span class="ribbon">New Arrival</span>
        <?php endif; ?>
        <img id="mainImg" class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" />
      </div>

      <div class="small-img-group">
        <?php
          $thumbs = array_filter([
            $row['product_image']  ?? null,
            $row['product_image2'] ?? null,
            $row['product_image3'] ?? null,
            $row['product_image4'] ?? null
          ]);
          $i = 0;
          foreach ($thumbs as $t):
            if(!$t) continue; $i++;
        ?>
          <div class="small-img-col">
            <img class="small-img" src="assets/imgs/<?php echo htmlspecialchars($t); ?>" width="100%" alt="thumb <?php echo $i; ?>" />
          </div>
        <?php endforeach; ?>
      </div>
    
<?php
$lowThreshold = 6;            
$stock = (int)$stock;       

if ($stock <= 0): ?>
  <div class="stocks-note out">Out of stock</div>

<?php elseif ($stock < $lowThreshold): ?>
  <div class="stocks-note low">Only <?= $stock ?> left remaining!</div>

<?php else: ?>
  <div class="stocks-note ok"><?= $stock ?> left remaining</div>
<?php endif; ?>


    </div>

    <!-- right side info -->
    <div class="col-lg-6 col-md-12 col-12 offset-lg-1">
      <div class="pill-style">Stationery</div>
      <h1 class="product-title"><?php echo htmlspecialchars($row['product_name']); ?></h1><hr>
      <div class="details-card">
  <h4 class="details-heading"><strong>Product Details:</strong></h4>
  <p class="product-desc">
    <?php echo nl2br(htmlspecialchars($row['product_description'] ?? '')); ?>
  </p>
</div>

         
   
 <div class="price-box text-start">
  
 <!-- Display price with promo code -->
 <?php if ($promoPrice !== null): ?>
    <div class="promo-line mb-1">
      With promo <span class="code">$<?= number_format($promoPrice, 2) ?></span>
      <small>(<?= (int)$discountPercent ?>% off)</small>
    </div>
  <?php endif; ?>

  <!-- Display market price if price is greater than price-main -->
  <?php 
     $marketPrice = isset($row['market_price']) && $row['market_price'] !== '' ? (float)$row['market_price'] : null;
     if ($marketPrice !== null && $marketPrice > 0 && $marketPrice != $price): ?>
     <div class="mb-1" style="color: #d32f2f; font-size: 1rem; font-weight: 500;">Market Price: $<?= number_format($marketPrice, 2) ?></div>
   <?php endif; ?>

  <div class="price-main mb-1">$<?= number_format($price, 2) ?></div>

  <?php if ($savings > 0): ?>
    <div class="save-pill">SAVE $<?= number_format($savings, 2) ?></div>
  <?php endif; ?>
</div>


   <?php
  $stock = isset($row['product_stock']) ? (int)$row['product_stock'] : 0;
  $isOut = $stock <= 0;
?>

<form method="POST" action="cart.php">
  <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
  <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
  <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/>
  <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>

  <input type="number" name="product_quantity" value="1" min="1" step="1"  required/>
  <button class="buy-btns" type="submit" name="add_to_cart">Add To Cart</button>
</form>



    </div>
    <?php endwhile; ?>
  </div>
</section>


<!-- related products  -->
<?php
$relStmt = $conn->prepare("
  SELECT product_id, product_name, product_price, product_image
  FROM products
  WHERE product_id <> ? 
  ORDER BY RAND()
  LIMIT 4
");
$relStmt->bind_param("i", $product_id);
$relStmt->execute();
$related = $relStmt->get_result();
?>

<section id="featured" class="my-5 pb-5">
  <div class="container text-center mt-5 py-3">
    <h4 class="mb-1">You may also like</h4>
    <hr class="mx-auto" />
  </div>

  <div class="row mx-auto container-fluid">
    <?php while ($r = $related->fetch_assoc()): ?>
      <div class="product text-center col-lg-3 col-md-4 col-sm-12">
        <a href="single_product.php?product_id=<?= (int)$r['product_id'] ?>">
          <img class="img-fluid mb-3"
               src="assets/imgs/<?= htmlspecialchars($r['product_image'] ?: '1.png') ?>"
               alt="<?= htmlspecialchars($r['product_name']) ?>" />
        </a>
        <h5 class="p-name"><?= htmlspecialchars($r['product_name']) ?></h5>
        <h4 class="p-price">$<?= number_format((float)$r['product_price'], 2) ?></h4>
        <a class="buy-btn" href="single_product.php?product_id=<?= (int)$r['product_id'] ?>">View</a>
      </div>
    <?php endwhile; ?>
    <?php if ($related->num_rows === 0): ?>
      <div class="col-12 text-center text-muted">No other products yet.</div>
    <?php endif; ?>
  </div>
</section>


<script>
  const mainImg = document.getElementById("mainImg");
  const smallImgs = document.getElementsByClassName("small-img");
  for (let i = 0; i < smallImgs.length; i++) {
    smallImgs[i].onclick = function () {
      mainImg.src = smallImgs[i].src;
    } }
</script>

<?php include('layouts/footer.php'); ?>

<script>

  const mainImg = document.getElementById("mainImg");
  const smallImgs = document.getElementsByClassName("small-img");
  for (let i = 0; i < smallImgs.length; i++) {
    smallImgs[i].onclick = function () { mainImg.src = smallImgs[i].src; }
  }
  const qty = document.querySelector('input[name="product_quantity"]');
  if (qty) {
    qty.addEventListener('input', function () {
      const v = parseInt(this.value, 10);
      if (isNaN(v) || v < 1) this.value = 1;
    });
    qty.addEventListener('keydown', function (e) {
      if (['e','E','+','-','.'].includes(e.key)) e.preventDefault();
    });
  }
</script>
