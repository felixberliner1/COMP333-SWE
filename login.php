<?php
    session_start();
    include("connection.php");
    if(isset($_POST['btn'])) {
        $username = $_POST['user'];
        $_SESSION['username'] = $username;
        $password = $_POST['pass'];

        $sql = "SELECT password, salt FROM login WHERE username = ?"; // Added
        $stmt = mysqli_prepare($conn, $sql); // Added
        mysqli_stmt_bind_param($stmt, "s", $username); // Added
        mysqli_stmt_execute($stmt); // Added
        mysqli_stmt_store_result($stmt); // Added
        mysqli_stmt_bind_result($stmt, $hashed_password, $salt); // Added
        
        if(mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_fetch($stmt);
    
            // Modified: Hash the entered password with the stored salt and verify
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

  
?>
