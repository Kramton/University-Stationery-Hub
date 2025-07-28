<?php include('header.php'); ?>

<?php
  
  include('../server/connection.php');

  if(isset($_SESSION['admin_logged_in'])) {
    header('location: index.php');
    exit;
  }

  if(isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT admin_id, admin_name, admin_email, admin_password FROM admins WHERE admin_email = ? AND admin_password = ? LIMIT 1");
    $stmt->bind_param('ss', $email, $password);

    if($stmt->execute()) {
      $stmt->bind_result($admin_id, $admin_name, $admin_email, $admin_password);
      $stmt->store_result();

      if($stmt->num_rows() == 1) {
        $stmt->fetch();

        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_name'] = $admin_name;
        $_SESSION['admin_email'] = $admin_email;
        $_SESSION['admin_logged_in'] = true;

        header('location: index.php?login_success=Logged in successfully');
      } else {
        header('location: login.php?error=Account verification failed');
      }
    } else {
      header('location: login.php?error=Something went wrong');
    }
  }
?>

      <!-- Login -->
    <section class="my-5 py-5">
      <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Login</h2>
        <hr class="mx-auto" />
      </div>
      <div class="mx-auto container">
        <form id="login-form" method="POST" action="login.php">
          <p style="color: red;" class="text-center"><?php if(isset($_GET['error'])) { echo $_GET['error']; } ?></p>
          <div class="form-group">
            <label for="">Email</label>
            <input
              type="text"
              class="form-control"
              id="login-email"
              name="email"
              placeholder="Email"
              required
            />
          </div>
          <div class="form-group">
            <label for="">Password</label>
            <input
              type="text"
              class="form-control"
              id="login-password"
              name="password"
              placeholder="Password"
              required
            />
          </div>
          <div class="form-group">
            <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login" />
          </div>
        </form>
      </div>
    </section>


  <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
    integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
    integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
    crossorigin="anonymous"></script>
  <script src="dashboard.js"></script>