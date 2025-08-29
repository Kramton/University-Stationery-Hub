<?php include('layouts/header.php'); ?>
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

<style>
  /*  Single product styles */
  .single-product .ribbon {
    position:absolute; top:12px; left:12px; z-index:3;
    background:#000; color:#fff; font-size:.72rem; letter-spacing:.04em;
    padding:4px 8px; border-radius:9999px; opacity:.9;
  }
  .single-product .img-wrap { position:relative; }
  .single-product #mainImg { border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,.08); }
  .small-img-group { display:grid; grid-template-columns:repeat(4,1fr); gap:.5rem; margin-top:.75rem; }
  .small-img-col img { border-radius:10px; cursor:pointer; border:1px solid #eee; }
  .small-img-col img:hover { transform:scale(1.02); transition:.15s ease; }

  .pill-cat { font-size:.8rem; color:#6b7280; text-transform:uppercase; letter-spacing:.08em; }
  .product-title { font-size:2.2rem; font-weight:800; line-height:1.1; margin:.25rem 0 1rem; }
  .product-desc { color:#374151; font-size:1rem; line-height:1.6; }

  .promo-line { color:#ef4444; font-weight:800; font-size:1.25rem; margin:1.25rem 0 .25rem; }
  .promo-line .code { color:#ef4444; }
  .price-main { font-size:2.5rem; font-weight:900; margin:.25rem 0; }
  .save-pill { display:inline-block; background:#0ea5e9; color:#fff; font-weight:700; border-radius:9999px; padding:.25rem .75rem; margin:.25rem 0 1rem; }

  .buy-btn {
    background:#111827; color:#fff; border:0; border-radius:12px; padding:.9rem 1.25rem;
    font-weight:700; font-size:1.05rem; width:100%; max-width:280px;
  }
  .buy-btn:hover { background:#000; }

  .qty-input {
    width:96px; border:1px solid #e5e7eb; border-radius:10px; padding:.6rem .75rem; margin-right:.75rem;
  }

  .stock-note {
    color:#f97316; font-weight:700; text-align:center; margin-top:1rem;
  }
  #featured .product { border:1px solid #f3f4f6; border-radius:14px; padding:1rem; box-shadow:0 2px 10px rgba(0,0,0,.03); }
</style>


<section class="container single-product my-5 pt-5">
  <div class="row mt-5">
    <?php while($row = $product->fetch_assoc()): 
      $price       = (float)$row['product_price'];
      $promoPrice  = isset($row['product_promo_price']) && $row['product_promo_price'] !== '' ? (float)$row['product_promo_price'] : null;
      $isNew       = isset($row['product_is_new']) ? (int)$row['product_is_new'] : 0;
      $stock       = isset($row['product_stock']) && $row['product_stock'] !== '' ? (int)$row['product_stock'] : 5; // fallback 5
      $savings     = $promoPrice ? max(0, $price - $promoPrice) : 0;
    ?>
    
    <!-- left gallery -->
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

      <?php if ($stock > 0): ?>
  <div class="stock-note">Only <?php echo $stock; ?> left remaining!</div>
<?php else: ?>
  <div class="stock-note" style="color:#ef4444">Out of stock</div>
<?php endif; ?>
    </div>

    <!-- right Info -->
    <div class="col-lg-6 col-md-12 col-12 offset-lg-1">
      <div class="pill-cat">Stationery</div>
      <h1 class="product-title"><?php echo htmlspecialchars($row['product_name']); ?></h1>

      <p class="product-desc">
        <?php echo nl2br(htmlspecialchars($row['product_description'] ?? '')); ?>
      </p>

      <?php if ($promoPrice && $promoPrice > 0): ?>
        <div class="promo-line">With promo code <span class="code">$<?php echo number_format($promoPrice, 2); ?></span></div>
      <?php endif; ?>

      <div class="price-main">$<?php echo number_format($price, 2); ?></div>

      <?php if ($savings > 0): ?>
        <div class="save-pill">SAVE $<?php echo number_format($savings, 0); ?></div>
      <?php endif; ?>

     <?php
  // compute stock right before the form
  $stock = isset($row['product_stock']) ? (int)$row['product_stock'] : 0;
  $isOut = $stock <= 0;
?>

<form method="POST" action="cart.php">
  <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
  <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
  <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/>
  <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>

  <input type="number" name="product_quantity" value="1" />
  <button class="buy-btn" type="submit" name="add_to_cart">Add To Cart</button>
</form>



    </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- related products -->
<section id="featured" class="my-5 pb-5">
  <div class="container text-center mt-5 py-5">
    <h3>Related Products</h3>
    <hr class="mx-auto" />
  </div>

  <div class="row mx-auto container-fluid">
    <div class="product text-center col-lg-3 col-md-4 col-sm-12">
      <img class="img-fluid mb-3" src="assets/imgs/1.png" alt="" />
      <h5 class="p-name">Product</h5>
      <h4 class="p-price">$199</h4>
      <button class="buy-btn">Buy Now</button>
    </div>
    <div class="product text-center col-lg-3 col-md-4 col-sm-12">
      <img class="img-fluid mb-3" src="assets/imgs/1.png" alt="" />
      <h5 class="p-name">Product</h5>
      <h4 class="p-price">$199</h4>
      <button class="buy-btn">Buy Now</button>
    </div>
    <div class="product text-center col-lg-3 col-md-4 col-sm-12">
      <img class="img-fluid mb-3" src="assets/imgs/1.png" alt="" />
      <h5 class="p-name">Product</h5>
      <h4 class="p-price">$199</h4>
      <button class="buy-btn">Buy Now</button>
    </div>
    <div class="product text-center col-lg-3 col-md-4 col-sm-12">
      <img class="img-fluid mb-3" src="assets/imgs/1.png" alt="" />
      <h5 class="p-name">Product</h5>
      <h4 class="p-price">$199</h4>
      <button class="buy-btn">Buy Now</button>
    </div>
  </div>
</section>

<script>
  // image swap 
  const mainImg = document.getElementById("mainImg");
  const smallImgs = document.getElementsByClassName("small-img");
  for (let i = 0; i < smallImgs.length; i++) {
    smallImgs[i].onclick = function () {
      mainImg.src = smallImgs[i].src;
    }
  }
</script>

<?php include('layouts/footer.php'); ?>
