<?php include('header.php'); ?>

<?php
if (isset($_GET['product_id'])) {

    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();

    $products = $stmt->get_result(); // return an array[]

} else if (isset($_POST['edit_btn'])) {
    $product_id = $_POST['product_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $market_price = $_POST['market_price'];
    $category = $_POST['category'];
    $stock = isset($_POST['stock']) ? max(0, (int)$_POST['stock']) : 0;

    // Update product details
    $stmt = $conn->prepare("UPDATE products SET product_name=?, product_description=?, product_price=?,
                                   market_price=?, product_category=?, product_stock=? WHERE product_id=?");
    // Assign type-casted values to variables for bind_param
    $price_f = (float)$price;
    $market_price_f = (float)$market_price;
    $stock_i = (int)$stock;
    $product_id_i = (int)$product_id;
    $stmt->bind_param('ssddsii', $title, $description, $price_f, $market_price_f, $category, $stock_i, $product_id_i);
    $success = $stmt->execute();
    $stmt->close();

    // Handle image uploads if any, otherwise preserve existing image file names
    $image_fields = ['image1', 'image2', 'image3', 'image4'];
    $image_names = [];
    // Fetch current image names from DB (in case not all are being updated)
    $stmt_img_fetch = $conn->prepare("SELECT product_image, product_image2, product_image3, product_image4 FROM products WHERE product_id=?");
    $stmt_img_fetch->bind_param('i', $product_id);
    $stmt_img_fetch->execute();
    $stmt_img_fetch->bind_result($cur_img1, $cur_img2, $cur_img3, $cur_img4);
    $stmt_img_fetch->fetch();
    $stmt_img_fetch->close();

    $current_images = [
        'image1' => $cur_img1,
        'image2' => $cur_img2,
        'image3' => $cur_img3,
        'image4' => $cur_img4
    ];

    foreach ($image_fields as $idx => $field) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $ext = ".jpeg";
            // Use a unique filename to avoid browser caching and collisions
            $unique = uniqid();
            $img_name = $title . ($idx + 1) . "_" . $unique . $ext;
            $dest = "../assets/imgs/" . $img_name;
            move_uploaded_file($_FILES[$field]['tmp_name'], $dest);
            $image_names[$field] = $img_name;
        } else {
            // No new upload, keep the current image name
            $image_names[$field] = $current_images[$field];
        }
    }

    // Only update DB if any image actually changed
    $update_needed = false;
    foreach ($image_fields as $field) {
        if ($image_names[$field] !== $current_images[$field]) {
            $update_needed = true;
            break;
        }
    }
    if ($update_needed) {
        $sql = "UPDATE products SET product_image=?, product_image2=?, product_image3=?, product_image4=? WHERE product_id=?";
        $stmt_img = $conn->prepare($sql);
        $stmt_img->bind_param('ssssi', $image_names['image1'], $image_names['image2'], $image_names['image3'], $image_names['image4'], $product_id);
        $stmt_img->execute();
        $stmt_img->close();
    }

    if ($success) {
        header('location: products.php?edit_success_message=Product updated successfully.');
    } else {
        header('location: products.php?edit_failure_message=Error occured, please try again.');
    }

} else {
    header('location: products.php');
    exit;
}

?>

<div class="container-fluid">
    <div class="row" style="min-height: 1000px">
        <?php include('sidemenu.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items center pt-3 pb-2 mb-3">
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">

                    </div>
                </div>
            </div>


            <h2>Edit Product</h2>
            <div class="table-responsive">
                <div class="mx-auto container">
                    <form action="edit_product.php" method="POST" id="edit-form" enctype="multipart/form-data">
                        <p style="color: red;"> <?php if (isset($_GET['error'])) {
                            echo $_GET['error'];
                        } ?> </p>

                        <div class="form-group mt-2">

                            <?php foreach ($products as $product) { ?>
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

                                <label for="">Title</label>
                                <input type="text" class="form-control" id="product-name"
                                    value="<?php echo $product['product_name']; ?>" name="title" placeholder="Title"
                                    required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="">Description</label>
                                <textarea class="form-control" id="product-desc" name="description"
                                rows="5" style="resize: vertical;" required><?php
                          echo htmlspecialchars($product['product_description']);
                          ?></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <label for="">Price</label>
                                <input type="number" step="0.01" class="form-control" id="product-price"
                                    value="<?php echo htmlspecialchars($product['product_price']); ?>" name="price" placeholder="Price"
                                    required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="">Category</label>
                                <select class="form-select" required name="category">
                                    <option value="Writing Essentials" <?php if ($product['product_category'] == 'Writing Essentials') echo 'selected'; ?>>Writing Essentials</option>
                                    <option value="Notebooks & Paper" <?php if ($product['product_category'] == 'Notebooks & Paper') echo 'selected'; ?>>Notebooks & Paper</option>
                                    <option value="Desk Accessories" <?php if ($product['product_category'] == 'Desk Accessories') echo 'selected'; ?>>Desk Accessories</option>
                                    <option value="Creative Supplies" <?php if ($product['product_category'] == 'Creative Supplies') echo 'selected'; ?>>Creative Supplies</option>
                                    <option value="Study Tools" <?php if ($product['product_category'] == 'Study Tools') echo 'selected'; ?>>Study Tools</option>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label for="">Market Price</label>
                                <input type="number" step="0.01" class="form-control"
                                    value="<?php echo htmlspecialchars($product['market_price']); ?>" id="market-price" name="market_price"
                                    placeholder="Market Price" required>
                            </div>
                           
                            <div class="form-group mt-2">
                            <label for="product-stock">Stock</label>
                            <input type="number" class="form-control" id="product-stock"
                                   value="<?php echo isset($product['product_stock']) ? (int)$product['product_stock'] : 0; ?>"
                                   name="stock" placeholder="Units in stock" min="0" step="1" required> </div>

                            <div class="form-group mt-2">
                                <label for="image1">Image 1</label>
                                <input type="file" class="form-control" id="image1" name="image1" placeholder="Image 1">
                                <small class="text-muted">Current: <?php echo htmlspecialchars($product['product_image']); ?></small>
                            </div>
                            <div class="form-group mt-2">
                                <label for="image2">Image 2</label>
                                <input type="file" class="form-control" id="image2" name="image2" placeholder="Image 2">
                                <small class="text-muted">Current: <?php echo htmlspecialchars($product['product_image2']); ?></small>
                            </div>
                            <div class="form-group mt-2">
                                <label for="image3">Image 3</label>
                                <input type="file" class="form-control" id="image3" name="image3" placeholder="Image 3">
                                <small class="text-muted">Current: <?php echo htmlspecialchars($product['product_image3']); ?></small>
                            </div>
                            <div class="form-group mt-2">
                                <label for="image4">Image 4</label>
                                <input type="file" class="form-control" id="image4" name="image4" placeholder="Image 4">
                                <small class="text-muted">Current: <?php echo htmlspecialchars($product['product_image4']); ?></small>
                            </div>
                            <div class="form-group mt-3 d-flex gap-2">
                                <input type="submit" class="btn btn-primary" name="edit_btn" value="Save">
                                <a href="products.php" class="btn btn-secondary" style="background-color: #dc3545; color: #fff; border: none;">Cancel</a>
                            </div>

                        <?php } ?>
                    </form>

                </div>
            </div>
        </main>
    </div>
</div>

<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
    integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
    integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
    crossorigin="anonymous"></script>
<script src="dashboard.js"></script>