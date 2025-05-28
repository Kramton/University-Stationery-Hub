<?php

include("dbconnection.php");

$email = $_POST["email"];
$psw = $_POST["psw"];

$sql = "
        insert into logintest (email, password)
        values ('$email', '$psw');
        ";

if ($conn->query($sql) === TRUE) {
    echo "Added " . $email;
} else {
    echo "Error: " . $sql . $conn->error;
}

$query = "select * from logintest";
$result = mysqli_query($conn, $query);

$conn->close();
?>