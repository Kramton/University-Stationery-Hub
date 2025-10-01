<?php include('header.php'); ?>

<?php

include('../server/connection.php');

if(isset($_POST['create_product'])) {

    $product_name = $_POST['name'];
    $product_description = $_POST['description'];
    $product_price = $_POST['price'];
    $product_special_offer = $_POST['offer'];
    $product_stock = isset($_POST['stock']) ? max(0, (int)$_POST['stock']) : 0;
    $product_category = $_POST['category'];

    // This is the file of the image 
    $image1 = $_FILES['image1']['tmp_name'];
    $image2 = $_FILES['image2']['tmp_name'];
    $image3 = $_FILES['image3']['tmp_name'];
    $image4 = $_FILES['image4']['tmp_name'];
  
    // Make a safe base for filenames (avoid spaces/specials)
    $safe_base = preg_replace('/[^A-Za-z0-9_\-]/', '_', strtolower($product_name));
    if ($safe_base === '') { $safe_base = 'product'; }
    
    
    // image names
    $image_name1 = $product_name."1.jpeg";
    $image_name2 = $product_name."2.jpeg";
    $image_name3 = $product_name."3.jpeg";
    $image_name4 = $product_name."4.jpeg";

    // upload images
    move_uploaded_file($image1, "../assets/imgs/" . $image_name1);
    move_uploaded_file($image2, "../assets/imgs/" . $image_name2);
    move_uploaded_file($image3, "../assets/imgs/" . $image_name3);
    move_uploaded_file($image4, "../assets/imgs/" . $image_name4);

    // ---- Insert including product_stock ----
    $stmt = $conn->prepare(
        "INSERT INTO products
         (product_name, product_description, product_price, product_special_offer,
          product_image, product_image2, product_image3, product_image4,
          product_category, product_stock)
         VALUES (?,?,?,?,?,?,?,?,?,?)"
    );

    $stmt->bind_param(
        "ssdisssssi",
        $product_name,
        $product_description,
        $product_price,          
        $product_special_offer,   
        $image_name1,
        $image_name2,
        $image_name3,
        $image_name4,
        $product_category,
        $product_stock           
    );

    if ($stmt->execute()) {
        $stmt->close();
        header('Location: products.php?product_created=' . urlencode('Product created successfully'));
        exit;
    } else {
        $stmt->close();
        header('Location: add_product.php?error=' . urlencode('Error occurred, please try again.'));
        exit;
    }
}
?>