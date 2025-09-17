<?php
session_start();
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
            $link = '<a href="login.php">Go to Login Page</a>';
        } else {
            $message_type = "error";
            $title = "Verification Failed!";
            $message = "There was a problem verifying your account. Please try again or contact support.";
            $link = '';
        }

    } else {
        $message_type = "error";
        $title = "Verification Failed!";
        $message = "This verification link is invalid, has expired, or has already been used.";
        $link = '';
    }

} else {
    $message_type = "error";
    $title = "Invalid Request";
    $message = "No verification token was provided. Please use the link sent to your email.";
    $link = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title); ?></title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: auto; background-color: #fff; border: 1px solid #ccc; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1.success { color: #4CAF50; }
        h1.error { color: #f44336; }
        p { font-size: 1.1em; color: #555; }
        a { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; }
        a:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="<?php echo $message_type; ?>"><?php echo htmlspecialchars($title); ?></h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <?php echo $link; ?>
    </div>
</body>
</html>