<?php
    session_start();
    include("connection.php");
    if(isset($_POST['btn'])) {
        $username = $_POST['user'];
        $_SESSION['username'] = $username;
        $password = $_POST['pass'];
        //Gets password from the associated username (parameterized)
        $sql = "SELECT password FROM login WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username); 
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_store_result($stmt); 
        mysqli_stmt_bind_result($stmt, $hashed_password); 
        
        if(mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_fetch($stmt);
            //If password and username don't match, sends you back to index w/ loginsuccessful set to false
            //Otherwise, sends you to the welcome page
            if(password_verify($password, $hashed_password)) {
                $_SESSION['loggedin'] = true;
                header("Location: welcome.php");
                exit();
            } else {
                $_SESSION['loginsuccessful'] = false;
                header("Location: index.php");
            }
        } else {
            $_SESSION['loginsuccessful'] = false;
            header("Location: index.php");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    
    }
?>
