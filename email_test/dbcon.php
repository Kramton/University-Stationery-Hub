<?php
    // $conn = new mysqli('database-1.cbeu6c08gvb5.ap-southeast-2.rds.amazonaws.com', 'admin', 'UniversityProject+2114', 'test');\
    $host = "database-1.cbeu6c08gvb5.ap-southeast-2.rds.amazonaws.com";
    $user = "admin";
    $pswd = "UniversityProject+2114";
    $dbnm = "users";
    $db = new PDO("mysql:host=$host;dbname=$dbnm", $user, $pswd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    
    // echo "Connected successfully<br><br>";
?>