<?php include('header.php'); ?>

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
                    <form action="" id="edit-form" enctype="multipart/form-data">
                        <p style="color: red;"> <?php if(isset($_GET['error'])){ echo $_GET['error']; } ?> </p>
                        
                        <div class="form-group mt-2">
                            <label for="">Title</label>
                            <input type="text" class="form-control" id="product-name" name="title" placeholder="Title">
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Description</label>
                            <input type="text" class="form-control" id="product-desc" name="description" placeholder="Description">
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Price</label>
                            <input type="number" class="form-control" id="product-price" name="price" placeholder="Product Price">
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Category</label>
                            <select class="form-select" required name="category" id="">
                                <option value="bags">Bags</option>
                                <option value="shoes">Shoes</option>
                                <option value="watches">Watches</option>
                                <option value="clothes">Clothes</option>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Color</label>
                            <input type="number" class="form-control" id="product-price" name="color" placeholder="Color">
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Special Offer/Sale</label>
                            <input type="number" class="form-control" id="product-price" name="sale" placeholder="Sale %">
                        </div>

                        <div class="form-group mt-2">
                            <a class="btn btn-primary" href="edit_product.php?product_id=<?php echo $product['product_id']; ?>">Edit</a>
                        </div>
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