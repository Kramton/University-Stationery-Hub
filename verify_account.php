<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include('server/connection.php');


if (isset($_GET['token']) && !empty($_GET['token'])) {
    
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE verification_token = ? AND is_verified = 0");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt_update = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE verification_token = ?");
        $stmt_update->bind_param('s', $token);

        if ($stmt_update->execute()) {
            $message_type = "success";
            $title = "Verification Successful!";
            $message = "Your account has been successfully verified. You can now log in.";
            $button_text = "Go to Login Page";
            $button_link = "login.php";
        } else {
            $message_type = "error";
            $title = "Verification Failed!";
            $message = "There was a problem verifying your account. Please try again or contact support.";
            $button_text = "Return to Home";
            $button_link = "index.php";
        }

    } else {
        $message_type = "error";
        $title = "Verification Failed!";
        $message = "This verification link is invalid, has expired, or has already been used.";
        $button_text = "Return to Home";
        $button_link = "index.php";
    }

} else {
    $message_type = "error";
    $title = "Invalid Request";
    $message = "No verification token was provided. Please use the link sent to your email.";
    $button_text = "Return to Home";
    $button_link = "index.php";
}

require_once __DIR__ . '/layouts/header.php';
?>

<style>
  .wrap { max-width: 1100px; margin: 100px auto 50px; padding: 0 16px; }

  /* Verification Card*/
  .card { 
    background: #fff; 
    border: 1px solid #eee; 
    border-radius: 16px; 
    box-shadow: 0 6px 18px rgba(0,0,0,.06); 
    overflow: hidden;
    max-width: 600px; 
    margin: 0 auto;   
  }

  .head {
    color: #fff;
    padding: 20px 24px;
    font-size: 24px;
    font-weight: 800;
    text-align: center;
  }
  .head.bg-success { background-color: #28a745; } /* Green for success */
  .head.bg-danger  { background-color: #ff7f50; } /* Red for error */

  .body {
    padding: 30px;
    background: #fff;
    text-align: center;
  }
  .body p {
    font-size: 1.1em;
    color: #555;
    margin: 0 0 25px;
  }
  .body .btn {
    display: inline-block;
    background: #ff7f50;
    color: #fff;
    padding: 12px 24px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
  }
  .body .btn:hover {
    background: #d6600d; /* Darker orange on hover */
  }
</style>

<div class="wrap">
  <div class="card">
    
    <div class="head <?php echo ($message_type === 'success') ? 'bg-success' : 'bg-danger'; ?>">
      <?php echo htmlspecialchars($title); ?>
    </div>

    <div class="body">
      <p><?php echo htmlspecialchars($message); ?></p>

      <a href="<?php echo htmlspecialchars($button_link); ?>" class="btn">
        <?php echo htmlspecialchars($button_text); ?>
      </a>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>