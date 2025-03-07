<?php
    $servername = "sql209.infinityfree.com";  // Your MySQL Host Name
    $username = "if0_38465106";               // Your MySQL User Name
    $password = "SWE3332025";                 // Your MySQL Password
    $db_name = "if0_38465106_app_db";         // Your MySQL Database Name

    $conn = new mysqli($servername, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
