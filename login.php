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

 