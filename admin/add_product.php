<?php include('header.php'); ?>


<?php

if (!isset($_SESSION['admin_logged_in'])) {
  header('location: login.php');
  exit();
}



?>

<div class="container-fluid">
  <div class="row">

    <?php include('sidemenu.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h1>Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                
            </div>
        </div>
      </div>
    
      <h2>Create Product</h2>
      <div class="table-responsive">
        <div class="mx-auto-container">
            <form id="create-form" enctype="multipart/form-data" method="POST" action="create_product.php">
                <p style="color: red;"><?php if(isset($_GET['error'])) { echo $_GET['error']; } ?></p>

                <div class="form-group mt-2">
                    <label for="">Title</label>
                    <input type="text" class="form-control" id="product-name" name="name" placeholder="Title" required>
                </div>
                <div class="form-group mt-2">
                    <label for="">Description</label>
                    <input type="text" class="form-control" id="product-desc" name="description" placeholder="Description" required>
                </div>
                <div class="form-group mt-2">
                    <label for="">Price</label>
                    <input type="text" class="form-control" id="product-price" name="price" placeholder="Price" required>
                </div>
                <div class="form-group mt-2">
                    <label for="">Special Offer/Sale</label>
                    <input type="text" class="form-control" id="product-offer" name="offer" placeholder="Offer" required>
                </div>

                <div class="form-group mt-2">
                    <label for="">Category</label>
                    <select class="form-select" required name="category">
                        <option value="bags">Writing Essentials</option>
                        <option value="shoes">Notebooks & Paper</option>
                        <option value="watches">Desk Accessories</option>
                        <option value="clothes">Creative Supplies</option>
                        <option value="clothes">Study Tools</option>
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label for="">Color</label>
                    <input type="text" class="form-control" id="product-color" name="color" placeholder="Color" required>
                </div>

                <div class="form-group mt-2">
                    <label for="">Image 1</label>
                    <input type="file" class="form-control" id="image1" name="image1" placeholder="Image 1" >
                </div>

                <div class="form-group mt-2">
                    <label for="">Image 2</label>
                    <input type="file" class="form-control" id="image2" name="image2" placeholder="Image 2" >
                </div>

                <div class="form-group mt-2">
                    <label for="">Image 3</label>
                    <input type="file" class="form-control" id="image3" name="image3" placeholder="Image 3" >
                </div>

                <div class="form-group mt-2">
                    <label for="">Image 4</label>
                    <input type="file" class="form-control" id="image4" name="image4" placeholder="Image 4" >
                </div>

                <div class="form-group mt-3">
                    <input type="submit" class="btn btn-primary" name="create_product" value="Create">
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