<?php include('layouts/header.php'); ?>
<?php
include('server/connection.php');

// Ensure cart array exists
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Fetch a product by id with safe fields.
function getProductById(mysqli $conn, int $id)
{
  $stmt = $conn->prepare(
    "SELECT product_id, product_name, product_image, product_price, product_stock
     FROM products WHERE product_id = ?"
  );
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  $row = $res->fetch_assoc();
  $stmt->close();
  return $row ?: null;
}

// calculate cart totals (price & quantity).
function calculateTotalCart()
{
  $total_price = 0.0;
  $total_quantity = 0;

  if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $line) {
      $price    = (float)$line['product_price'];
      $quantity = (int)$line['product_quantity'];
      $total_price    += ($price * $quantity);
      $total_quantity += $quantity;
    }
  }

  // Apply promo code if valid
  if (isset($_SESSION['promo_code']) && $_SESSION['promo_code'] === 'AUT112') { // Example promo code
    $_SESSION['promo_discount'] = 5.00;
  } else {
    unset($_SESSION['promo_discount']);
  }

  $_SESSION['subtotal']    = $total_price;
  $_SESSION['quantity'] = $total_quantity;
}


// back URL (referrer or index)
$backUrl = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : 'index.php';

// ======================== Add to cart =========================
if (isset($_POST['add_to_cart'])) {
  $product_id    = (int)$_POST['product_id'];
  $requested_qty = max(1, (int)$_POST['product_quantity']);

  $product = getProductById($conn, $product_id);
  if (!$product) {
    echo "<script>alert('Product not found.'); window.location=" . json_encode($backUrl) . ";</script>";
    exit;
  }

  $available_stock = (int)$product['product_stock'];
  if ($available_stock <= 0) {
    echo "<script>alert('Sorry, this product is out of stock'); window.location=" . json_encode($backUrl) . ";</script>";
    exit;
  }

  if ($requested_qty > $available_stock) {
    $requested_qty = $available_stock; // clamp
    echo "<script>alert('Quantity adjusted to available stock ($available_stock)');</script>";
  }

  // Merge with existing cart line if present
  if (isset($_SESSION['cart'][$product_id])) {
    $existing_qty = (int)$_SESSION['cart'][$product_id]['product_quantity'];
    $new_qty = min($existing_qty + $requested_qty, $available_stock);
    $_SESSION['cart'][$product_id]['product_quantity'] = $new_qty;
  } else {
    // Build cart line from DB values (don’t trust POST)
    $_SESSION['cart'][$product_id] = [
      'product_id'       => $product['product_id'],
      'product_name'     => $product['product_name'],
      'product_price'    => (float)$product['product_price'],
      'product_image'    => $product['product_image'],
      'product_quantity' => $requested_qty
    ];
  }

  calculateTotalCart();

  // Remove from cart 
} else if (isset($_POST['remove_product'])) {
  $product_id = (int)$_POST['product_id'];
  unset($_SESSION['cart'][$product_id]);
  calculateTotalCart();

  // Edit quantity
} else if (isset($_POST['edit_quantity'])) {
  $product_id   = (int)$_POST['product_id'];
  $new_quantity = (int)$_POST['product_quantity'];

  $product = getProductById($conn, $product_id);
  if (!$product) {
    echo "<script>alert('Product not found.');</script>";
  } else {
    $available_stock = (int)$product['product_stock'];

    if ($new_quantity <= 0) {
      // 0 or negative means remove the item
      unset($_SESSION['cart'][$product_id]);
    } else if ($available_stock <= 0) {
      unset($_SESSION['cart'][$product_id]);
      echo "<script>alert('Sorry, this product is now out of stock and was removed from your cart.');</script>";
    } else {
      if ($new_quantity > $available_stock) {
        $new_quantity = $available_stock;
        echo "<script>alert('Quantity adjusted to available stock ($available_stock)');</script>";
      }
      if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['product_quantity'] = $new_quantity;
      }
    }
  }

  calculateTotalCart();

// Apply Promo Code
} else if (isset($_POST['apply_promo'])) {
    $promo_code = trim($_POST['promo_code']);
    // Replace 'AUT112' with your actual valid promo code logic
    if ($promo_code === 'AUT112') { 
        $_SESSION['promo_code'] = $promo_code;
    } else {
        unset($_SESSION['promo_code']);
        echo "<script>alert('Invalid promo code.');</script>";
    }
    calculateTotalCart();
}

// Initial calculation on page load
calculateTotalCart();

?>

<style>
  :root {
    --primary-color: #F97316; 
  }

  .cart {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }

  .cart-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
  }
  
  .cart-table-container {
    width: 100%;
    border-collapse: collapse;
  }
  
  
  .cart-table-container th {
    color: white;
    padding: 15px 10px;
    text-align: left;
    font-weight: bold;
  }

  .cart-table-container td {
    padding: 20px 10px;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
  }
  
  .product-info {
    display: flex;
    align-items: center;
  }

  .product-info img {
    width: 60px;
    height: auto;
    margin-right: 15px;
  }
  
  .quantity-column {
    text-align: left;
  }

  .stock-status {
    font-size: 0.85em;
    color: #6c757d;
    display: block;
    margin-bottom: 5px;
  }

  .quantity-selector {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: fit-content;
  }

  .quantity-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.2rem;
    padding: 5px 12px;
    color: #555;
  }

  .quantity-text {
    padding: 0 15px;
    font-size: 1rem;
  }
  
  .subtotal-column {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .promo-and-total-container {
    display: flex;
    flex-direction: column;  
    align-items: center;
    margin-top: 40px;
  }
  
  .promo-container {
    min-width: 280px;
    margin-bottom: 20px;
  }

  .cart-total-container {
    width: 100%;
    max-width: 450px;
    
  }

  .promo-container form {
    display: flex;
    max-width: 350px;
  }
  
  .promo-container input[type="text"] {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-right: none;
    border-radius: 5px 0 0 5px;
  }

  .apply-btn {
    padding: 10px 20px;
    background-color: var(--primary-color);
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 0 5px 5px 0;
    text-transform: uppercase;
    font-weight: bold;
  }
  
  .cart-total-container h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
  }

  .cart-total-table {
    width: 100%;
    max-width: 400px;
  }
  
  .cart-total-table td {
    padding: 8px 0;
    font-size: 1.1rem;
    border: none;
  }
  
  .cart-total-table td:first-child {
      font-weight: bold;
  }

  .cart-total-table tr td:last-child {
    text-align: right;
  }

  .cart-total-table hr {
    border: 0;
    border-top: 1px solid #ddd;
    margin: 10px 0;
  }


</style>


<!-- Cart -->
<section class="cart">
  <div class="container">
    <h2 class="cart-title">Your Cart</h2>
  </div>

  <table class="cart-table-container">
    <thead>
      <tr>
        <th style="width: 40%;">Product</th>
        <th style="width: 15%;">Price</th>
        <th style="width: 25%;">Quantity</th>
        <th style="width: 20%;">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($_SESSION['cart'])) : ?>
        <?php foreach ($_SESSION['cart'] as $value) : ?>
          <?php
            $stock_row = getProductById($conn, (int)$value['product_id']);
            $live_stock = $stock_row ? (int)$stock_row['product_stock'] : 0;
          ?>
          <tr>
            <td>
              <div class="product-info">
                <img src="assets/imgs/<?php echo htmlspecialchars($value['product_image']); ?>" alt="<?php echo htmlspecialchars($value['product_name']); ?>" />
                <p><?php echo htmlspecialchars($value['product_name']); ?></p>
              </div>
            </td>

            <td>$<?php echo number_format((float)$value['product_price'], 2); ?></td>

            <td class="quantity-column">
              <?php if ($live_stock == 1) : ?>
                <span class="stock-status">last stock</span>
              <?php elseif ($live_stock > 1 && $live_stock <= 10) : ?>
                <span class="stock-status"><?php echo $live_stock; ?> stock left</span>
              <?php endif; ?>
              
              <div class="quantity-selector">
                <form method="POST" action="cart.php" class="d-inline">
                  <input type="hidden" name="product_id" value="<?php echo (int)$value['product_id']; ?>" />
                  <input type="hidden" name="product_quantity" value="<?php echo (int)$value['product_quantity'] - 1; ?>" />
                  <button type="submit" name="edit_quantity" class="quantity-btn">-</button>
                </form>

                <span class="quantity-text"><?php echo (int)$value['product_quantity']; ?></span>
                
                <form method="POST" action="cart.php" class="d-inline">
                  <input type="hidden" name="product_id" value="<?php echo (int)$value['product_id']; ?>" />
                  <input type="hidden" name="product_quantity" value="<?php echo (int)$value['product_quantity'] + 1; ?>" />
                  <button type="submit" name="edit_quantity" class="quantity-btn">+</button>
                </form>
              </div>
            </td>

            <td>
              <div class="subtotal-column">
                <span>$<?php echo number_format(((float)$value['product_price'] * (int)$value['product_quantity']), 2); ?></span>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo (int)$value['product_id']; ?>" />
                    <button type="submit" name="remove_product" class="remove-btn" title="Remove item">&#128465;</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
            <td colspan="4" class="text-center py-5">Your cart is empty.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <div class="promo-and-total-container">
    <div class="promo-container">
      <form method="POST" action="cart.php">
        <label for="promo_code" class="visually-hidden">Promo code</label>
        <input type="text" name="promo_code" id="promo_code" placeholder="Promo code">
        <button type="submit" name="apply_promo" class="apply-btn">Apply</button>
      </form>
    </div>

    <div class="cart-total-container">
        <h3>Cart Total</h3>
        <table class="cart-total-table">
            <tbody>
                <tr>
                    <td>Subtotal:</td>
                    <td>$<?php echo number_format($_SESSION['subtotal'] ?? 0.00, 2); ?></td>
                </tr>
                <?php if (isset($_SESSION['promo_discount'])): ?>
                <tr>
                    <td>Promo Discount:</td>
                    <td>-$<?php echo number_format($_SESSION['promo_discount'], 2); ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td class="colspan" colspan="2"><hr></td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td>$<?php 
                        $final_total = ($_SESSION['subtotal'] ?? 0.00) - ($_SESSION['promo_discount'] ?? 0.00);
                        echo number_format($final_total, 2); 
                    ?></td>
                </tr>
            </tbody>
        </table>
        <div class="checkout-container">
            <form method="POST" action="checkout.php">
                <button type="submit" name="checkout" class="checkout-btn">Check Out</button>
            </form>
        </div>
    </div>
  </div>
</section>

<?php include('layouts/footer.php'); ?>