<?php
session_start();
include('server/connection.php');

// If user is already logged in, redirect them to their profile page and stop the script.
if (!empty($_SESSION['logged_in'])) {
  header('Location: my_profile.php');
  exit;
}

if (isset($_POST['login_btn'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password, is_verified 
                          FROM users WHERE user_email = ? LIMIT 1");
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['user_password'])) {
      
      // Check if the user's email is verified
      if ($user['is_verified'] == 1) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['logged_in'] = true;

        // Redirect to the profile page with a success message
        header('Location: my_profile.php?login_success=Logged in successfully');
        exit;
      } else {
        // User exists but is not verified
        header('Location: login.php?error=Please verify your email address before logging in.');
        exit;
      }
    } else {
      // Password was incorrect
      header('Location: login.php?error=Invalid credentials');
      exit;
    }
  } else {
    // No user found with that email
    header('Location: login.php?error=Invalid credentials');
    exit;
  }
}

include('layouts/header.php'); 
?>

<!-- Login -->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="form-weight-bold">Login to your account</h2>
  </div>
  <div class="mx-auto container">
    <form id="login-form" method="POST" action="login.php">
      <div class="form-group">
        <a id="register-url" href="register.php" class="btn">New to University Stationery Hub? Register now</a>
      </div>

      <p style="color: red;" class="text-center"><?php if (isset($_GET['error'])) {
                                                  echo htmlspecialchars($_GET['error']); // Added htmlspecialchars for security
                                                } ?></p>

      <div class="form-group">
        <label for="login-email">Email:</label>
        <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required />
      </div>

      <div class="form-group">
        <label for="login-password">Password:</label>
        <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required />
      </div>

      <div class="form-group">
        <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login" />
      </div>

      <div class="form-group">
        <a id="password-reset-url" href="forgot_password.php" class="btn">Forgot Password?</a>
      </div>

    </form>
  </div>
</section>

<?php include('layouts/footer.php') ?>