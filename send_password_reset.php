<?php

include('server/connection.php');

$email = $_POST["email"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30); // expires in 30 minutes

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

    Click <a href="http://localhost/UniversityStationaryHub/University-Stationary-Hub/reset_password.php?token=$token">here</a> to reset your password.

    END;

    try {
        $mail->send();
    } catch(Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
}

echo "Message sent, please check your inbox."; //TODO: create page for message sent

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