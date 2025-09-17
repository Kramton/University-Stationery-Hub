<?php
session_start();

require_once 'dbcon.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html'); 
    exit;
}

$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit;
}

try {
    $query = "SELECT id, username, email, password, is_verified FROM email_test WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['is_verified'] && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username']; 
            $_SESSION['email'] = $user['email'];

            echo json_encode(['success' => true, 'message' => 'Login successful!']);

        } elseif (!$user['is_verified']) {
            echo json_encode(['success' => false, 'message' => 'Please verify your email address to log in.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    }

} catch (PDOException $e) {
    error_log("Login database error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred during login. Please try again later.']);
}

?>