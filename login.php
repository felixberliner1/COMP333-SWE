<?php
    session_start();
    include("connection.php");
    if(isset($_POST['btn'])) {
        $username = $_POST['user'];
        $_SESSION['username'] = $username;
        $password = $_POST['pass'];

        $sql = "SELECT password, salt FROM login WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username); 
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_store_result($stmt); 
        mysqli_stmt_bind_result($stmt, $hashed_password, $salt); 
        
        if(mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_fetch($stmt);
    
            if(password_verify($salt . $password, $hashed_password)) {
                header("Location: welcome.php");
                exit();
            } else {
                echo  '<script>
                    window.location.href = "index.php"
                    alert("Login failed. Invalid username or password.")
                    </script>';
            }
        } else {
            echo  '<script>
                window.location.href = "index.php"
                alert("Login failed. Invalid username or password.")
                </script>';
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    
    }
?>
