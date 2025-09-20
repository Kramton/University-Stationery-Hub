<?php include('layouts/header.php') ?>

<style>
  .reset-btn {
    background-color: coral;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
  }
</style>

<!-- Reset Password -->
<section id="contact" class="container my-5 py-5">
  <div class="container text-center mt-5">
    <h2 class="form-weight-bold">Forgot Password</h2>
    <hr class="mx-auto" />

  </div>

  <form class="container text-center" method="POST" action="send_password_reset.php">
    <div>
      <p>Enter your email and we'll send a link to reset your password.</p>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-md-4">
        <div class="d-grid gap-2">
          <input required type="email" name="email" id="email" placeholder="Enter your email" class="form-control">
          <button class="reset-btn">Reset Password</button>
        </div>
      </div>
    </div>
  </form>

</section>

<!-- Footer -->
<?php include('layouts/footer.php') ?>