
<?php
/* 
require 'vendor/autoload.php';
require 'dbcon.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    try {
        require_once 'dbcon.php';
        $query = "INSERT INTO users (username,password,email) VALUES (:username,:password,:email);";

        $stmt = $db->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $db = null;
        $stmt = null;

        header('Location: register.html');
        die();

    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

} else{
    header('Location: register.html');
}


*/
