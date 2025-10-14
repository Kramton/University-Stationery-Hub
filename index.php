<?php include('layouts/header.php'); ?>
<?php include('server/connection.php'); ?>
<link rel="stylesheet" href="assets/css/style.css?v=6">




<!-- Home -->
 <a href="shop.php">
   <section id="home" class="hero-parallax">
     <div class="hero-bg"></div>
     <div class="container hero-content">
   
       <!-- <h5>NEW ARRIVALS</h5>
           <h1><span>Best Prices</span> This Season</h1>
           <p>
             University Stationary Hub offers the best products for the most
             affordable prices
           </p>
           <button>Shop Now</button>-->
     </div>
   </section>
 </a>

<!-- Random Picks-->

<?php
$random_stmt = $conn->prepare("
  SELECT product_id, product_name, product_price, product_image, market_price
  FROM products
  ORDER BY RAND()
  LIMIT 12
");
$random_stmt->execute();
$res = $random_stmt->get_result();
$items = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
$groups = array_chunk($items, 4);
?>

<section id="random-picks" class="my-5">
  <div class="container-xxl px-4">
    <div class="section-header d-flex align-items-center justify-content-between mb-4">
      <h3 class="mb-0">Suggested For You</h3>
      <a href="shop.php" class="btn btn-outline-dark btn-see-all">See All</a>
    </div>

    <?php if (!empty($groups)): ?>
      <div id="suggestCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">

          <?php foreach ($groups as $i => $group): ?>
            <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
              <div class="row g-3">
                <?php foreach ($group as $r): ?>
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card product-card h-100">
                      <a href="<?php echo 'single_product.php?product_id=' . (int) $r['product_id']; ?>"
                        class="text-decoration-none text-dark">
                        <div class="img-wrap">
                          <img src="assets/imgs/<?php echo htmlspecialchars($r['product_image'] ?: 'placeholder.png'); ?>"
                            class="card-img-top" alt="<?php echo htmlspecialchars($r['product_name']); ?>" />
                        </div>
                        <div class="card-body">
                          <h6 class="card-title mb-1 text-truncate" style="font-size:1.2rem;"><strong><?php echo htmlspecialchars($r['product_name']); ?></strong></h6>
                          <?php
                          $marketPrice = isset($r['market_price']) && $r['market_price'] !== '' ? (float) $r['market_price'] : null;
                          if ($marketPrice !== null && $marketPrice > 0 && $marketPrice != $r['product_price']): ?>
                            <div class="mb-1" style="color: #d32f2f; font-size: 1rem; font-weight: 500;">Market Price:
                              $<?php echo number_format($marketPrice, 2); ?></div>
                          <?php endif; ?>
                          <p class="card-text fw-bold mb-0" style="font-size:1.5rem;">$<?php echo number_format((float) $r['product_price'], 2); ?></p>
                        </div>
                      </a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>


        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#suggestCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#suggestCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>

      </div>
    <?php else: ?>
      <p class="text-muted mb-0">No products found. Error</p>
    <?php endif; ?>
  </div>
</section>


<!-- categories strip  -->
<section id="categories" class="my-5">
  <div class="container-xxl px-e">
    <div class="section-header d-flex align-items-center justify-content-between mb-4">
      <h3 class="mb-0">Browse by Category</h3>

    </div>

    <?php
    $categories = [
      ['name' => 'Writing Essentials', 'img' => 'assets/imgs/WritingEssentialsIcon.png'],
      ['name' => 'Notebooks & Paper', 'img' => 'assets/imgs/Notebooks&Paper.png'],
      ['name' => 'Desk Accessories', 'img' => 'assets/imgs/DeskAccessories.png'],
      ['name' => 'Creative Supplies', 'img' => 'assets/imgs/CreativeSupplies.png'],
      ['name' => 'Study Tools', 'img' => 'assets/imgs/StudyTools.png'],
    ];
    ?>

    <div class="row g-4 justify-content-center">
      <?php foreach ($categories as $c): ?>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card product-card h-100">
            <a href="shop.php?cat=<?php echo urlencode($c['name']); ?>" class="text-decoration-none text-dark">
              <div class="img-wrap">
                <img src="<?php echo htmlspecialchars($c['img']); ?>" class="card-img-top"
                  alt="<?php echo htmlspecialchars($c['name']); ?>" />
              </div>
              <div class="card-body">
                <h6 class="card-title mb-1 text-truncate">
                  <?php echo htmlspecialchars($c['name']); ?>
                </h6>
                <p class="card-text fw-bold mb-0">Explore Now</p>
              </div>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>


  </div>
</section>









<!-- Banner 2 for sale  -->
<section id="banner" class="my-5 py-5">
  <div class="container">
    <!-- <h4>ON SALE</h4> -->
    <h1>
      Stationary <br />
      UP to 30% OFF
    </h1>
    <!-- <button class="text-uppercase">Shop Now</button>-->
  </div>
</section>

<?php

$sale_stmt = $conn->prepare("
  SELECT 
    product_id, product_name, product_price, product_image, market_price,
    /* optional columns if they exist in your DB: */
    IFNULL(product_special_offer, NULL) AS product_special_offer,
    IFNULL(product_special_offer, NULL) AS product_special_offer
  FROM products
  WHERE 
    /* case A: explicit promo price set */
    (product_special_offer IS NOT NULL AND product_special_offer <> '' AND product_special_offer > 0)
    /* case B: special offer flag/percent present */
    OR (product_special_offer IS NOT NULL AND product_special_offer <> '' AND product_special_offer <> '0')
  ORDER BY product_id DESC
  LIMIT 12
");
$sale_stmt->execute();
$sale_products = $sale_stmt->get_result();
?>

<!--On wsale product -->
<section id="sale" class="my-5">
  <div class="container-xxl px-4">
    <div class="section-header d-flex align-items-center justify-content-between mb-4">
      <h3 class="mb-0">On Sale</h3>
    </div>

    <?php if ($sale_products && $sale_products->num_rows > 0): ?>
      <div class="row g-4">
        <?php while ($row = $sale_products->fetch_assoc()):
          $price = (float) $row['product_price'];

          $promoPrice = null;

          if (!empty($row['product_promo_price']) && (float) $row['product_promo_price'] > 0) {
            $promoPrice = (float) $row['product_promo_price'];
          } elseif (!empty($row['product_special_offer']) && $row['product_special_offer'] !== '0') {
            $offerVal = (float) $row['product_special_offer'];
            if ($offerVal > 0 && $offerVal <= 90) {
              $promoPrice = round($price * (1 - $offerVal / 100), 2);
            }
          }

          $hasPromo = ($promoPrice !== null && $promoPrice > 0 && $promoPrice < $price);
          $saveAmt = $hasPromo ? max(0, $price - $promoPrice) : 0;
          ?>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product-card h-100 position-relative">
              <?php if ($hasPromo): ?><span class="sale-badge">SALE</span><?php endif; ?>

              <a href="<?php echo 'single_product.php?product_id=' . (int) $row['product_id']; ?>"
                class="text-decoration-none text-dark">
                <div class="img-wrap">
                  <img src="assets/imgs/<?php echo htmlspecialchars($row['product_image'] ?: 'placeholder.png'); ?>"
                    class="card-img-top" alt="<?php echo htmlspecialchars($row['product_name']); ?>" />
                </div>

                <div class="card-body">
                  <h6 class="card-title mb-1 text-truncate" style="font-size:1.2rem;">
                    <strong><?php echo htmlspecialchars($row['product_name']); ?></strong>
                  </h6>

                  <?php
                  $marketPrice = isset($row['market_price']) && $row['market_price'] !== '' ? (float) $row['market_price'] : null;
                  if ($marketPrice !== null && $marketPrice > 0 && $marketPrice != $price): ?>
                    <div class="mb-1" style="color: #d32f2f; font-size: 1rem; font-weight: 500;">Market Price:
                      $<?php echo number_format($marketPrice, 2); ?></div>
                  <?php endif; ?>
                  <?php if ($hasPromo): ?>
                    <div class="price-wrap">
                      <span class="new-price" style="font-size:1.5rem;">$<?php echo number_format($promoPrice, 2); ?></span>
                      <span class="old-price" style="font-size:1.5rem;">$<?php echo number_format($price, 2); ?></span>
                    </div>
                    <div class="save-chip">You save $<?php echo number_format($saveAmt, 2); ?></div>
                  <?php else: ?>
                    <p class="card-text fw-bold mb-0" style="font-size:1.5rem;">
                      $<?php echo number_format($price, 2); ?>
                    </p>
                  <?php endif; ?>
                </div>
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-muted mb-0">No promo items yet. Check back soon!</p>
    <?php endif; ?>
  </div>
</section>


<?php include('layouts/footer.php') ?>