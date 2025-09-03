<?php

$host = 'localhost';    
$dbname = 'email_test'; 
$username = 'root';         // Default XAMPP username
$password = '';             // Default XAMPP password

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}