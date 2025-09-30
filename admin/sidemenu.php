<?php 
$current_page = basename($_SERVER['PHP_SELF']); // This code gets the current page name

function setActiveClass($page, $current_page) {
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
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <!-- Other Sidebar Links -->
            <li class="nav-item">
                <a class="nav-link <?php echo setActiveClass('index.php', $current_page); ?>" href="index.php" id="orders-btn">
                    <span data-feather="file"></span>
                    Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo setActiveClass(['products.php', 'add_product.php', 'edit_product.php', 'edit_images.php'], $current_page); ?>" href="products.php" id="products-btn">

                    <span data-feather="shopping-cart"></span>
                    Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo setActiveClass(['promo_codes.php', 'add_promo_code.php', 'edit_promo_code.php'], $current_page); ?>" href="promo_codes.php" id="promo-codes-btn">
            <span data-feather="tag"></span>
            Promo Codes
        </a>
    </li>
        </ul>
    </div>
</nav>

<style>
    #sidebarMenu {
        background-color: #f1f1f1;
        margin-top: 0;
        padding-top: 10px;
    }

    .nav-link {
        color: #000;
        padding: 10px 15px;
        font-size: 0.9rem;
        font-weight: 500;
        background-color: #f1f1f1;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .nav-link:hover, .nav-link:focus {
        background-color: #FF9F7F;
        text-decoration: none;
        color: black;
    }

    .nav-link.disabled {
        background-color: #f1f1f1;
        color: #666;
        cursor: not-allowed;
    }

    .nav-link.active {
        background-color: #FF9F7F;
        color: white;
    }

    /* User Info Section (above buttons) */
    .user-info {
        padding: 15px;
        font-size: 1rem;
        background-color: #f1f1f1;
        margin-bottom: 10px;
    }

    .user-name {
        font-weight: 600;
        font-size: 1rem;
    }

    .user-email {
        font-size: 0.875rem;
        color: #666;
    }

    .nav-link.active {
        background-color: #FF7F50;
        color: white;
    }

</style>
