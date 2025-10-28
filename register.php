<?php include('layouts/header.php') ?>

<?php

require 'vendor/autoload.php';
require_once 'server/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generateVerificationToken() {
    return bin2hex(random_bytes(32));
}

function sendVerificationEmail($email, $verificationToken) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username = 'universitystationeryhub@gmail.com';
        $mail->Password = 'blan phaw gedq tdno';

        $mail->setFrom('universitystationeryhub@gmail.com', 'University Stationary Hub');
        $mail->addAddress($email);

        $verificationLink = 'http://localhost/University-Stationery-Hub/verify_account.php?token=' . $verificationToken;

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email Address';
        $mail->Body = <<<HTML
          <!DOCTYPE html>
          <html lang="en">
          <head>
              <meta charset="UTF-8">
              <title>Verify Your Email</title>
          </head>
          <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; margin-top: 40px; margin-bottom: 40px;">
                  <tr>
                      <td style="background-color: #ffffff; padding: 40px 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center;">
                          <h1 style="font-size: 24px; margin: 0 0 20px 0; color: #333333;">Verify Your Email</h1>
                          <p style="font-size: 16px; color: #555555; line-height: 1.5; margin: 0 0 30px 0;">
                              Thanks for signing up! Please click the button below to verify your account.
                          </p>
                          <!-- CTA Button -->
                          <a href="{$verificationLink}" target="_blank" style="background-color: #ff7f50; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                              Verify Account
                          </a>
                          <!-- Fallback Link -->
                          <p style="font-size: 12px; color: #888888; margin: 30px 0 0 0;">
                              If the button doesn't work, copy and paste this link into your browser:<br>
                              <a href="{$verificationLink}" target="_blank" style="color: #007bff;">{$verificationLink}</a>
                          </p>
                      </td>
                  </tr>
              </table>
          </body>
          </html>
          HTML;

          $mail->AltBody = <<<TEXT
          To verify your account, please use the following link:
          {$verificationLink}
          TEXT;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}


if(isset($_SESSION['logged_in'])) {
  header('location: my_profile.php');
  exit;
}

if(isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  // Check both passwords match
  if($password !== $confirmPassword) {
    header('location: register.php?error=Passwords do not match');
  }
  // Check password length is greater than 6
  else if(strlen($password) < 6) {
    header('location: register.php?error=Password must be at least 6 characters');
  }
  else {
      // Check whether this email is already in use
    $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
    $stmt1->bind_param('s', $email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->store_result();
    $stmt1->fetch();

    if($num_rows != 0) {
      header('location: register.php?error=User with this email already exists');
    } else {
 