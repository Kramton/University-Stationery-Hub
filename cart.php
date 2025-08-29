<?php include('layouts/header.php'); ?>
<?php
include('server/connection.php');

/*
// debug
function normalizeCartKeys() {
  if (empty($_SESSION['cart'])) return;

  $normalized = [];
  foreach ($_SESSION['cart'] as $k => $line) {
    if (!is_array($line) || !isset($line['product_id'])) continue;
    $pid = (int)$line['product_id'];
    if ($pid <= 0) {
      // fallback to old key if it was a valid int-like key
      $pid = is_numeric($k) ? (int)$k : 0;
    }
    if ($pid <= 0) continue; // skip malformed entries

    if (isset($normalized[$pid])) {
      // merge quantities if duplicated under different keys
      $normalized[$pid]['product_quantity'] += (int)($line['product_quantity'] ?? 0);
    } else {
      $line['product_id'] = $pid; // ensure int
      $line['product_quantity'] = max(1, (int)($line['product_quantity'] ?? 1));
      $normalized[$pid] = $line;
    }
  }
  $_SESSION['cart'] = $normalized;
}

// Ensure cart array exists, then normalize
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}
normalizeCartKeys();*/

// Fetch a product by id with safe fields.
 
function getProductById(mysqli $conn, int $id) {
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

function calculateTotalCart() {
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

  $_SESSION['total']    = $total_price;
  $_SESSION['quantity'] = $total_quantity;
}

// Ensure cart array exists
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}



// back URL (referrer or index)
$backUrl = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : 'index.php';

// Add to cart
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
      } else {
        // If editing a product not yet in cart, add it
        $_SESSION['cart'][$product_id] = [
          'product_id'       => $product['product_id'],
          'product_name'     => $product['product_name'],
          'product_price'    => (float)$product['product_price'],
          'product_image'    => $product['product_image'],
          'product_quantity' => $new_quantity
        ];
      }
    }
  }

  calculateTotalCart();
}
?>

<!-- Cart -->
<section class="cart container my-5 py-5">
  <div class="container mt-5">
    <h2 class="font-weight-bold text-center">Your Cart</h2>
    <hr class="mx-auto" />
  </div>

  <table class="mt-5 pt-5">
    <tr>
      <th>Product</th>
      <th>Quantity</th>
      <th>Subtotal</th>
    </tr>

    <?php if (!empty($_SESSION['cart'])): ?>
      <?php foreach ($_SESSION['cart'] as $value): ?>
        <?php
          // Get live stock to cap the input (nice UX; server still enforces)
          $stock_row = getProductById($conn, (int)$value['product_id']);
          $live_stock = $stock_row ? (int)$stock_row['product_stock'] : 0;
          $live_stock_max = max(1, $live_stock);
        ?>
        <tr>
          <td>
            <div class="product-info">
              <img src="assets/imgs/<?php echo htmlspecialchars($value['product_image']); ?>" alt="" />
              <div>
                <p><?php echo htmlspecialchars($value['product_name']); ?></p>
                <small><span>$</span><?php echo number_format((float)$value['product_price'], 2); ?></small>
                <br>
                <form method="POST" action="cart.php">
                  <input type="hidden" name="product_id" value="<?php echo (int)$value['product_id']; ?>" />
                  <input type="submit" name="remove_product" class="remove-btn" value="remove" />
                </form>
              </div>
            </div>
          </td>

          <td>
            <form method="POST" action="cart.php">
              <input type="hidden" name="product_id" value="<?php echo (int)$value['product_id']; ?>" />
              <input type="number" name="product_quantity"
                     value="<?php echo (int)$value['product_quantity']; ?>"
                     min="1" max="<?php echo $live_stock_max; ?>" />
              <input type="submit" class="edit-btn" value="edit" name="edit_quantity" />
            </form>
            <?php if ($live_stock <= 0): ?>
              <div class="text-danger" style="font-size: .9rem;">Currently out of stock</div>
            <?php elseif ($live_stock < (int)$value['product_quantity']): ?>
              <div class="text-warning" style="font-size: .9rem;">Reduced to max available: <?php echo $live_stock; ?></div>
            <?php endif; ?>
          </td>

          <td>
            <span>$</span>
            <span class="product-price">
              <?php echo number_format(((float)$value['product_price'] * (int)$value['product_quantity']), 2); ?>
            </span>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </table>

  <div class="cart-total">
    <table>
      <tr>
        <td>Total</td>
        <td>$ <?php echo isset($_SESSION['total']) ? number_format((float)$_SESSION['total'], 2) : '0.00'; ?></td>
      </tr>
    </table>
  </div>

  <div class="checkout-container">
    <form method="POST" action="checkout.php">
      <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
    </form>
  </div>
</section>

<?php include('layouts/footer.php'); ?>
