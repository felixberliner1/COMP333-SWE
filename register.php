<?php
session_start();
include("connection.php");

if(isset($_SESSION['username'])) {
    header("Location: welcome.php");
    exit();
}

if(isset($_POST['register'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['confirm_pass'];

    if($password !== $confirm_password) {
        header("Location: register.php?error=password_mismatch");
        exit();
    }

    $sql_check = "SELECT * FROM login WHERE username = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $username);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if(mysqli_num_rows($result_check) > 0) {
        echo '<script>alert("Username already taken. Please choose another.");</script>';
        exit();
    }

    $sql = "INSERT INTO login (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    
    if(mysqli_stmt_execute($stmt)) {
        $_SESSION['username'] = $username;
        echo '<script>
            alert("Registration successful! Redirecting to welcome page.");
            window.location.href = "welcome.php";
        </script>';
    } else {
        echo '<script>alert("Error: Unable to register. Please try again later.");</script>';
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt_check);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>

    <?php
    if(isset($_GET['error']) && $_GET['error'] == 'password_mismatch') {
        echo '<p style="color: red;">Passwords do not match! Please try again.</p>';
    }
    ?>

    <form action="register.php" method="post">
        <label>Username:</label>
        <input type="text" name="user" required>
        <br>
        <label>Password:</label>
        <input type="password" name="pass" required>
        <br>
        <label>Re-enter Password:</label>
        <input type="password" name="confirm_pass" required>
        <br>
        <button type="submit" name="register">Register</button>
    </form>

    <p>Already have an account? <a href="index.php">Login Here</a></p>
</body>
</html>
