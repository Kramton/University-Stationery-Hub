<?php

require 'vendor/autoload.php';
require_once 'dbcon.php';

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
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->Username = 'tempestplaysgrow@gmail.com';
        $mail->Password = 'qufq ctky rnis bzwd';

        $mail->setFrom('tempestplaysgrow@gmail.com', 'University Stationary Hub');
        $mail->addAddress($email);

        $verificationLink = 'http://localhost/verify.php?token=' . $verificationToken . '&email=' . urlencode($email);

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email Address';
        $mail->Body = '
            <p>Please verify your email address by clicking the link below:</p>
            <a href="' . $verificationLink . '">' . $verificationLink . '</a>';
        $mail->AltBody = 'Verify at: ' . $verificationLink;

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST["name"] ?? '';
    $password = $_POST["password"] ?? '';
    $email = $_POST["email"] ?? '';

    try {
        $checkQuery = "SELECT email FROM users WHERE email = :email";
        $checkStmt = $db->prepare($checkQuery);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            echo "Email already registered. Please use a different email address.";
            exit;
        }

        $verificationToken = generateVerificationToken();

        $query = "INSERT INTO users (username,password,email) VALUES (:username,:password,:email)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password); 
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if (sendVerificationEmail($email, $verificationToken)) {
            echo "Registration successful! Please check your email to verify your account.";
        } else {
            echo "User created but failed to send verification email.";
        }

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }

} else {
    header('Location: register.html');
    exit;
}
