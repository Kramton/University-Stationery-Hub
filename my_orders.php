<?php
include('layouts/header.php');
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch this user's orders (newest first)
$stmt = $conn->prepare("SELECT order_id, order_cost, order_status, order_date FROM orders WHERE user_id=? ORDER BY order_date DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<style>
/* Keep content below fixed navbar */
body { padding-top: 110px; font-family: 'Poppins', sans-serif; }

/* Match profile page wrapper + sidebar */
.account-container { max-width: 1200px; margin: auto; }
.account-title { font-size: 40px; font-weight: 600; text-align: center; margin-bottom: 40px; }

.sidebar { padding-right: 20px; }
.sidebar h5 { margin-bottom: 20px; font-weight: 500; }
.sidebar a { display: block; padding: 8px 0; color: #000; text-decoration: none; }
.sidebar a.active { color: #F15A29; font-weight: 600; }

/* Card */
.content-box {
    background:#fff; padding:30px; border-radius:6px;
    box-shadow:0 4px 10px rgba(0,0,0,0.05);
}
.content-box h5 { color:#F15A29; font-weight:500; margin-bottom: 12px; }
.content-box hr { border:0; height:2px; background:#F15A29; width:40px; margin:0 0 20px; }

/* Minimal orders table (like your reference) */
.order-table { width:100%; border-collapse:collapse; }
.order-table thead th {
    font-weight:500; font-size:14px; color:#000; text-align:left; padding:12px 14px;
    border-bottom:1px solid #e0e0e0;
}
.order-table tbody td {
    font-size:14px; color:#333; padding:16px 14px; border-bottom:1px solid #eee;
}
.order-table tbody tr:last-child td { border-bottom:none; }

/* “View Order” as a simple link */
.view-link { color:#000; font-weight:500; text-decoration:none; }
.view-link:hover { text-decoration:underline; }
</style>

<section class="account-container">
    <h2 class="account-title">Account</h2>

    <div class="row">
        <!-- Sidebar (identical to profile page) -->
        <div class="col-md-3 sidebar">
            <h5>Manage My Account</h5>
            <a href="my_profile.php">My Profile</a>
            <a href="my_orders.php" class="active">My Orders</a>
        </div>

        <!-- Orders -->
        <div class="col-md-9">
            <div class="content-box">
                <h5>My Orders</h5>
                <hr>

                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order#</th>
                            <th>Date</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($orders->num_rows > 0): ?>
                            <?php while ($row = $orders->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['order_id']; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['order_date'])); ?></td>
                                    <td>$<?php echo number_format((float)$row['order_cost'], 2); ?></td>
                                    <td><?php echo ucfirst($row['order_status']); ?></td>
                                    <td>
                                        <a class="view-link" href="order_details.php?order_id=<?php echo $row['order_id']; ?>">
                                            View Order
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="padding:18px 14px;">No orders found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include('layouts/footer.php'); ?>
