<?php

include('server/connection.php');

$email = $_POST["email"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30); // expires in 30 minutes

$stmt2 = $conn->prepare("SELECT user_name FROM users WHERE user_email = ?");
$stmt2->bind_param("s", $email);
$stmt2->execute();
$stmt2->bind_result($firstName);
$stmt2->fetch();
$stmt2->close();

$sql = "UPDATE users
         SET reset_token_hash = ?,
             reset_token_expires_at = ?
         WHERE user_email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($conn->affected_rows) {

  $mail = require __DIR__ . "/mailer.php";

  $mail->setFrom("example@gmail.com", "University Stationery Hub");
  $mail->addAddress($email);
  $mail->Subject = "Password Reset";
  $mail->Body = <<<END
    
    <div style="text-align: center;">
      <h2>Password Reset</h2>
      <hr style="width:50%; margin: 5px auto; text-align: center; padding: 10px; border-top: 1px solid coral; opacity: 1;" class="mx-auto" />
    </div>

    <div style="text-align: center; margin-bottom: 20px;">
      Hi $firstName, we received a request to reset your password.
    </div>

    <div style="text-align: center; margin: 30px 0;">
      <a href="http://localhost/University-Stationery-Hub/reset_password.php?token=$token"
      style="display: inline-block; padding: 12px 24px; background: coral; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold;">
      Reset Password
      </a>
    </div>

    <div style="text-align: center; color: black; font-size: 12px;">
      <b>Link will expire in 30 minutes. If you did not request a password reset, please ignore this message.</b>
    </div>

    <div style="text-align: center; color: #333; font-size: 14px; margin-top: 30px;">
      Best regards,<br>
      <b>The University Stationery Hub Team</b>
    </div>

    END;

  try {
    $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
  }
}

?>

<?php include('layouts/header.php') ?>

<!-- Reset Password Message Sent -->
<section id="contact" class="container my-5 py-5">
  <div class="container text-center mt-5">
    <h2 class="form-weight-bold">Check Email</h2>
    <hr class="mx-auto" />

  </div>

  <div class="container text-center">
    <p>Please check your email inbox and click on the link to reset password.</p>
  </div>


</section>

<!-- Footer -->
<?php include('layouts/footer.php') ?>


<?php

?>