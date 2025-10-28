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

