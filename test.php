<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>
<body>
    <h1>test</h1>
    <p>this is a paragraph</p>
    <p>this is another paragraph</p>
    <img src="./homerchu.png" alt="homerchu">

    <?php

    include("dbconnection.php");
    
    $result = $conn->query("select id, name from test;");
    
    if (mysqli_num_rows($result) > 0) {
    // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            echo "id: " . $row["id"]. " - Name: " . $row["name"];
        }
    } 
    else {
        echo "0 results";
    }

    mysqli_close($conn);
    ?>

    
</body>
</html>