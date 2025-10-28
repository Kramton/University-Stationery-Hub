<?php
$current_page = basename($_SERVER['PHP_SELF']); // This code gets the current page name

function setActiveClass($page, $current_page)
{
    if (is_array($page)) {
        return in_array($current_page, $page) ? 'active' : '';
    }
    return $page === $current_page ? 'active' : '';
}
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <!-- User Info Section -->
        <div class="user-info mb-3 px-3 py-2" style="border-bottom: 1px solid #ddd; background-color: #f1f1f1;">
            <div class="user-name" style="font-weight: 600; font-size: 1rem;">
                <?php
                // Fetch user info (Assuming session has user data, replace with actual logic)
                echo $_SESSION['admin_name'];
                ?>
            </div>
            <div class="user-email" style="font-size: 0.875rem; color: #666;">
                <?php echo $_SESSION['admin_email']; ?>
            </div>
        </div>

        <!-- Sidebar Links -->
        <ul class="nav flex-column">
            <!-- Dashboard - Not clickable -->
            <li class="nav-item">
                <a class="nav-link disabled" href="#" style="color: #000; background-color: #f1f1f1;">
                    <!-- <span data-feather="home"></span> -->
                    <h5>Admin Dashboard</h5>
                </a>
            </li>
            <!-- Other Sidebar Links -->
            <li class="nav-item">
                <a class="nav-link <?php echo setActiveClass('index.php', $current_page); ?>" href="index.php"
                    id="orders-btn">
                    <span data-feather="file"></span>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo setActiveClass(['products.php', 'add_product.php', 'edit_product.php', 'edit_images.php'], $current_page); ?>"
                    href="products.php" id="products-btn">

                    <span data-feather="shopping-cart"></span>
                    Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo setActiveClass(['promo_codes.php', 'add_promo_code.php', 'edit_promo_code.php'], $current_page); ?>"
                    href="promo_codes.php" id="promo-codes-btn">
                    <span data-feather="tag"></span>
                    Promo Codes
                </a>
            </li>
            <!-- Users Section -->
            <li class="nav-item">
                <a class="nav-link <?php echo setActiveClass('users.php', $current_page); ?>" href="users.php"
                    id="users-btn">
                    <span data-feather="users"></span>
                    Users
                </a>
            </li>
        </ul>
    </div>
</nav>

