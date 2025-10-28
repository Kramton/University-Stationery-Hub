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
    <p style="font-size:16px; margin-bottom:0; text-align:left;">
            <span style="font-weight:bold;">Order ID:</span>
            <span style="font-weight:normal;"> <?php echo '#USH' . str_pad($order_id, 4, '0', STR_PAD_LEFT); ?></span>
        </p>
        <?php if (!empty($order_date)): ?>
            <p style="font-size:16px; margin-bottom:0; text-align:left;">
                <span style="font-weight:bold;">Order Date:</span>
                <span style="font-weight:normal;"> <?php echo date('d M Y, h:i A', strtotime($order_date)); ?></span>
            </p>
        <?php
        // Fetch pickup name and address for display
        $pickup_name = '';
        $pickup_address = '';
        $pickup_phone = '';
        $stmt_addr = $conn->prepare("SELECT user_address, user_phone, pickup_name FROM orders WHERE order_id = ? LIMIT 1");
        $stmt_addr->bind_param('i', $order_id);
        $stmt_addr->execute();
        $result_addr = $stmt_addr->get_result();
        if ($row_addr = $result_addr->fetch_assoc()) {
            $pickup_address = $row_addr['user_address'];
            $pickup_phone = $row_addr['user_phone'];
            $pickup_name = $row_addr['pickup_name'];
        }
        $stmt_addr->close();
        ?>
            <!-- Add gap between order date and pickup info -->
            <div style="height:18px;"></div>
            <?php if ($pickup_name || $pickup_address): ?>
                <p style="font-size:16px; margin-bottom:0; text-align:left;">
                    <strong>To Be Picked Up By:</strong> <?= htmlspecialchars($pickup_name ?: 'Not provided') ?><br>
                    <strong>Pickup Address:</strong> <?= htmlspecialchars($pickup_address ?: 'Not provided') ?>
                </p>
        <?php endif; ?>
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
