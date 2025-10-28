<?php
include('layouts/header.php');
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch this user's orders (newest first)
$stmt = $conn->prepare("SELECT order_id, order_cost, order_status, order_date, ready_for_pickup FROM orders WHERE user_id=? ORDER BY order_date DESC");
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

    /* Remove fixed grid-template-columns for .grid, use Bootstrap row/col for layout */
    /*
    .grid {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 40px;
        align-items: start;
    }
    @media(max-width:992px) {
        .grid {
            grid-template-columns: 1fr;
        }
    }
    */

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
        border-collapse: collapse;
        min-width: 720px;
    }

    /* mobile-only horizontal scroll for the order table */
    .order-table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 24px;
        width: 100%;
        max-width: 100vw;
    }
    @media (max-width: 700px) {
        .order-table {
            min-width: 480px;
        }
    }

    .order-table thead th {
        font-weight: 500;
        font-size: 14px;
        color: #000;
        text-align: left;
        padding: 12px 14px;
        border-bottom: 1px solid #e0e0e0;
        white-space: nowrap;
    }

    .order-table tbody td {
        font-size: 14px;
        color: #333;
        padding: 16px 14px;
        border-bottom: 1px solid #eee;
        white-space: nowrap;
    }

    .order-table tbody tr:last-child td {
        border-bottom: none;
    }

    .view-link {
        color: #000;
        font-weight: 500;
        text-decoration: none;
        padding: 4px 10px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .view-link:hover {
        background: coral;
        color: #fff;
        text-decoration: none;
    }
</style>


