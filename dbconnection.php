<?php
    $conn = new mysqli('database-1.cbeu6c08gvb5.ap-southeast-2.rds.amazonaws.com', 'admin', 'UniversityProject+2114', 'test');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    echo "Connected successfully<br><br>";
?>