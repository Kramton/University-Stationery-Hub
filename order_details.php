<?php
include('layouts/header.php');
include('server/connection.php');


// Accept order_id from GET or POST
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $order_status = isset($_POST['order_status']) ? $_POST['order_status'] : null;
} elseif (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $order_status = null;
} else {
    header('location: account.php');
    exit;
}

// Fetch order_status and order_date from DB if not provided
$order_date = '';
if ($order_status === null) {
    $stmt_status = $conn->prepare("SELECT order_status, order_date FROM orders WHERE order_id = ? LIMIT 1");
    $stmt_status->bind_param('i', $order_id);
    $stmt_status->execute();
    $result_status = $stmt_status->get_result();
    if ($row_status = $result_status->fetch_assoc()) {
        $order_status = $row_status['order_status'];
        $order_date = $row_status['order_date'];
    } else {
        $order_status = '';
        $order_date = '';
    }
} else {
    // If order_status is set, still fetch order_date
    $stmt_date = $conn->prepare("SELECT order_date FROM orders WHERE order_id = ? LIMIT 1");
    $stmt_date->bind_param('i', $order_id);
    $stmt_date->execute();
    $result_date = $stmt_date->get_result();
    if ($row_date = $result_date->fetch_assoc()) {
        $order_date = $row_date['order_date'];
    }
}

$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param('i', $order_id);
$stmt->execute();
$order_details = $stmt->get_result();
$order_total_price = calculateTotalOrderPrice($order_details);

function calculateTotalOrderPrice($order_details)
{

    $total = 0;

    foreach ($order_details as $row) {
        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];

        $total = $total + ($product_price * $product_quantity);

    }

    return $total;
}



?>


<!-- Order details -->
<section id="orders" class="orders container my-5 py-3">

    <div class="container mt-5">
        <h2 class="font-weight-bold text-center">Order Details</h2>
        <hr class="mx-auto" />
        <p class="text-center" style="font-size:18px; color:#555; margin-bottom:0;">Order ID:
            <strong><?php echo htmlspecialchars($order_id); ?></strong></p>
        <?php if (!empty($order_date)): ?>
            <p class="text-center" style="font-size:16px; color:#888; margin-bottom:0;">Order Date:
                <strong><?php echo date('d M Y, h:i A', strtotime($order_date)); ?></strong></p>
        <?php endif; ?>
    </div>


    <table class="mt-5 pt-5 mx-auto">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>

        <?php foreach ($order_details as $row) { ?>
            <tr>
                <td>
                    <div class="product-info">
                        <img src="assets/imgs/<?php echo $row['product_image']; ?>" alt="" />
                        <div>
                            <p class="mt-3"><?php echo $row['product_name']; ?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <span>$<?php echo $row['product_price']; ?></span>
                </td>
                <td>
                    <span><?php echo $row['product_quantity']; ?></span>
                </td>
            </tr>
        <?php } ?>
    </table>



    <?php if ($order_status == "Open") { ?>
        <?php
        // Prepare last_order session for payment.php
        $order_items = [];
        foreach ($order_details as $row) {
            $order_items[] = [
                'name' => $row['product_name'],
                'quantity' => (int) $row['product_quantity'],
                'subtotal' => (float) $row['product_price'] * (int) $row['product_quantity']
            ];
        }
        $_SESSION['last_order'] = [
            'order_id' => $order_id,
            'items' => $order_items,
            'subtotal' => $order_total_price,
            'discount' => 0.0,
            'total' => $order_total_price
        ];
        ?>
        <form style="float: right; margin-left:10px;" method="POST" action="payment.php">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <input type="hidden" name="order_total_price" value="<?php echo $order_total_price; ?>">
            <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
            <input type="submit" name="order_pay_btn" class="btn btn-primary" value="Pay Now">
        </form>

        <!-- Cancel Order button triggers modal -->
        <button type="button" class="btn btn-danger" style="float: right; margin-right:10px; text-transform:capitalize;"
            onclick="showCancelModal()">Cancel Order</button>

        <!-- Modal and overlay -->
        <div id="cancelModalOverlay"
            style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.6); z-index:9998;">
        </div>
        <div id="cancelModal"
            style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#fff; padding:32px 28px; border-radius:8px; box-shadow:0 8px 32px rgba(0,0,0,0.18); z-index:9999; min-width:320px; text-align:center;">
            <h4 style="margin-bottom:18px;">Cancel & Delete Order?</h4>
            <p style="margin-bottom:24px; color:#555;">Are you sure you want to cancel this order? This cannot be undone.</p>
            <form method="POST" action="server/cancel_order.php" style="display:inline;">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <button type="submit" name="cancel_order_btn" class="btn btn-danger"
                    style="margin-right:10px; text-transform:capitalize;">Yes, Cancel</button>
            </form>
            <button type="button" class="btn btn-secondary" onclick="hideCancelModal()">No, Go Back</button>
        </div>

        <script>
            function showCancelModal() {
                document.getElementById('cancelModalOverlay').style.display = 'block';
                document.getElementById('cancelModal').style.display = 'block';
            }
            function hideCancelModal() {
                document.getElementById('cancelModalOverlay').style.display = 'none';
                document.getElementById('cancelModal').style.display = 'none';
            }
            // Hide modal if overlay is clicked
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('cancelModalOverlay').onclick = hideCancelModal;
            });
        </script>
    <?php } ?>

    <!-- Back to My Orders button -->
    <a href="my_orders.php" class="btn btn-secondary"
        style="float: left; background-color: #FF7F50; color: #fff; border: none;">Back to My Orders</a>

</section>









<?php include('layouts/footer.php') ?>