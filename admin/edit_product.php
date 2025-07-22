<?php include('header.php'); ?>

<?php 
if(isset($_GET['product_id'])) {

    $product_id = $_GET['product_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    
    $products = $stmt->get_result(); // return an array[]

} else if(isset($_POST['edit_btn'])) {
    $product_id = $_POST['product_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $offer = $_POST['offer'];
    $color = $_POST['color'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("UPDATE products SET product_name=?, product_description=?, product_price=?,
                                   product_special_offer=?, product_color=?, product_category=? WHERE product_id=?");
    $stmt->bind_param('ssssssi',$title, $description, $price, $offer, $color, $category, $product_id);

    if($stmt->execute()) {
        header('location: products.php?edit_success_message=Product updated successfully.');
    } else {
        header('location: products.php?edit_failure_message=Error occured, please try again.');
    }

} else {
    header('products.php');
    exit;
}

?>

<div class="container-fluid">
    <div class="row" style="min-height: 1000px">
        <?php include('sidemenu.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items center pt-3 pb-2 mb-3">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">

                    </div>
                </div>
            </div>


            <h2>Edit Product</h2>
            <div class="table-responsive">
                <div class="mx-auto container">
                    <form action="edit_product.php" method="POST" id="edit-form" >
                        <p style="color: red;"> <?php if(isset($_GET['error'])){ echo $_GET['error']; } ?> </p>
                        
                        <div class="form-group mt-2">
                        
                        <?php foreach($products as $product) { ?>
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

                            <label for="">Title</label>
                            <input type="text" class="form-control" id="product-name" value="<?php echo $product['product_name']; ?>" name="title" placeholder="Title" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Description</label>
                            <input type="text" class="form-control" id="product-desc" value="<?php echo $product['product_description']; ?>" name="description" placeholder="Description" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Price</label>
                            <input type="text" class="form-control" id="product-price" value="<?php echo $product['product_price']; ?>" name="price" placeholder="Price" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Category</label>
                            <select class="form-select" required name="category">
                                <option value="bags">Bags</option>
                                <option value="shoes">Shoes</option>
                                <option value="watches">Watches</option>
                                <option value="clothes">Clothes</option>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Color</label>
                            <input type="text" class="form-control" value="<?php echo $product['product_color']; ?>" id="product-color" name="color" placeholder="Color" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Special Offer/Sale</label>
                            <input type="number" class="form-control" value="<?php echo $product['product_special_offer']; ?>" id="product-offer" name="offer" placeholder="Sale %" required>
                        </div>
                        
                        <div class="form-group mt-3">
                            <input type="submit" class="btn btn-primary" name="edit_btn" value="Edit">
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
  integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
  integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
<script src="dashboard.js"></script>