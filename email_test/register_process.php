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
        $mail->Username = 'tempestplaysgrow@gmail.com'; // Your Gmail address
        $mail->Password = 'qufq ctky rnis bzwd';       // Your Gmail App Password

        $mail->setFrom('tempestplaysgrow@gmail.com', 'University Stationary Hub');
        $mail->addAddress($email);

        $verificationLink = 'http://localhost/university/University-Stationary-Hub/email_test/verification.php?token=' . $verificationToken;

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email Address';
        $mail->Body = '
            <p>Thank you for registering! Please verify your email address by clicking the link below:</p>
            <a href="' . $verificationLink . '">' . $verificationLink . '</a>';
        $mail->AltBody = 'To verify your account, please visit the following link: ' . $verificationLink;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST["name"] ?? '';
    $password = $_POST["password"] ?? '';
    $email = $_POST["email"] ?? '';

    if (empty($username) || empty($password) || empty($email)) {
        die("Please fill out all fields.");
    }

    try {
        $checkQuery = "SELECT email FROM email_test WHERE email = :email";
        $checkStmt = $db->prepare($checkQuery);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            echo "Email already registered. Please use a different email address or log in.";
            exit;
        }

        $verificationToken = generateVerificationToken();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO email_test (username, password, email, verification_token) VALUES (:username, :password, :email, :token)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword); // Store the hashed password
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $verificationToken);
        $stmt->execute();

        if (sendVerificationEmail($email, $verificationToken)) {
            echo "Registration successful! Please check your email inbox (and spam folder) to verify your account.";
        } else {
            echo "Registration was successful, but the verification email could not be sent. Please contact support.";
        }

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }

} else {
    header('Location: register.html');
    exit;
}