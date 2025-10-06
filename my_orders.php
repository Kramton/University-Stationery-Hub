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
    body {
        padding-top: 110px;
    }

    .container-account {
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 16px
    }

    .account-title {
        font-size: 36px;
        font-weight: 700;
        text-align: center;
        margin: 6px 0 26px
    }

    .grid {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 40px;
        align-items: start
    }

    @media(max-width:992px) {
        .grid {
            grid-template-columns: 1fr
        }
    }

    .sidebar-title {
        color: #7a7a7a;
        margin-bottom: 12px
    }

    .navlink {
        display: block;
        padding: 6px 0;
        color: black;
        text-decoration: none
    }

    .navlink.active {
        color: coral;
    }

    .content-box {
        background: #fff;
        padding: 30px;
        border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05)
    }

    .order-table {
        width: 100%;
        border-collapse: collapse
    }

    .order-table thead th {
        font-weight: 500;
        font-size: 14px;
        color: #000;
        text-align: left;
        padding: 12px 14px;
        border-bottom: 1px solid #e0e0e0
    }

    .order-table tbody td {
        font-size: 14px;
        color: #333;
        padding: 16px 14px;
        border-bottom: 1px solid #eee
    }

    .order-table tbody tr:last-child td {
        border-bottom: none
    }

    .view-link {
        color: #000;
        font-weight: 500;
        text-decoration: none
    }

    .view-link:hover {
        text-decoration: underline
    }
</style>


<div class="container-account">
    <h2 class="account-title">Account</h2>
    <div class="grid">
        <!-- Sidebar -->
        <aside>
            <!-- <div class="sidebar-title">Manage My Account</div> -->
            <h4 class="sidebar-title">Manage My Account</h4>
            <a class="navlink" href="my_profile.php">My Profile</a>
            <a class="navlink active" href="my_orders.php">My Orders</a>
        </aside>
        <!-- Main -->
        <main>
            <div class="">
                <h4>My Orders</h4>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order#</th>
                            <th>Date</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th style="text-align:left;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($orders->num_rows > 0): ?>
                            <?php while ($row = $orders->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo '#USH' . str_pad($row['order_id'], 4, '0', STR_PAD_LEFT); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['order_date'])); ?></td>
                                    <td>$<?php echo number_format((float) $row['order_cost'], 2); ?></td>
                                    <td><?php echo ucfirst($row['order_status']); ?></td>
                                    <td style="text-align:left; vertical-align:middle;">
                                        <a class="view-link" href="order_details.php?order_id=<?php echo $row['order_id']; ?>">
                                            View Order
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5"
                                    style="padding:32px 14px; text-align:center; vertical-align:middle; font-size:16px; color:#888;">
                                    No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include('layouts/footer.php'); ?>