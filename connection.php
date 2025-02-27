<?php
    $servername="localhost";
    $username = "root";
    $password= "";
    $db_name= "DB1";
    $conn= new mysqli($servername, $username, $password, $db_name);

    if ($conn->connect_error){
        die("Connection failed".$conn->conenct_error); 
    }
    echo "Connection Successul";
?>