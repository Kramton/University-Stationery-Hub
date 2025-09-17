<?php

require_once 'dbcon.php';

if (isset($_GET['token']) && !empty($_GET['token'])) {
    
    $token = $_GET['token'];

    try {
        $query = "SELECT id FROM email_test WHERE verification_token = :token AND is_verified = FALSE";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            
            $updateQuery = "UPDATE email_test SET is_verified = TRUE, verification_token = NULL WHERE verification_token = :token";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bindParam(':token', $token);
            $updateStmt->execute();

            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Verification Successful</title>
                <style>
                    body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                    .container { max-width: 600px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 5px; }
                    h1 { color: #4CAF50; }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Email Verification Successful!</h1>
                    <p>Your account has been successfully verified. You can now log in.</p>
                    <a href="login.html">Go to Login Page</a>
                </div>
            </body>
            </html>';

        } else {
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Verification Failed</title>
                 <style>
                    body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                    .container { max-width: 600px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 5px; }
                    h1 { color: #f44336; }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Verification Failed!</h1>
                    <p>This verification link is invalid, has expired, or has already been used.</p>
                </div>
            </body>
            </html>';
        }

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }

} else {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invalid Request</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
            .container { max-width: 600px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 5px; }
            h1 { color: #f44336; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Invalid Request</h1>
            <p>No verification token was provided. Please use the link sent to your email.</p>
        </div>
    </body>
    </html>';
}