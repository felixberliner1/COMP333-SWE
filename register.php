<?php
session_start();
include("connection.php");

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: welcome.php");
    exit();
}

if(isset($_POST['register'])) {
    $username = trim($_POST['user']);
    $password = trim($_POST['pass']);
    $confirm_password = trim($_POST['confirm_pass']);

    // Check if password is at least 10 characters long
    if(strlen($password) < 10) { 
        echo '<script>
            alert("Password must be at least 10 characters long."); 
            window.location.href = "register.php";
        </script>';
        exit();
    }

    // Check if passwords match
    if($password !== $confirm_password) {
        header("Location: register.php?error=password_mismatch");
        exit();
    }

    //Check if username already exists
    $sql_check = "SELECT COUNT(*) FROM login WHERE username = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $username);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_bind_result($stmt_check, $user_count);
    mysqli_stmt_fetch($stmt_check);
    mysqli_stmt_close($stmt_check);

    if($user_count > 0) {
        echo '<script>
            alert("Username already taken. Please choose another.");
            window.location.href = "register.php";
        </script>';
        exit();
    }

    //Hash password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //Insert new user into the database
    $sql = "INSERT INTO login (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

    if(mysqli_stmt_execute($stmt)) {
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
        echo '<script>
            alert("Registration successful! Redirecting to welcome page.");
            window.location.href = "welcome.php";
        </script>';
    } else {
        echo '<script>alert("Error: Unable to register. Please try again later.");</script>';
    }

    //Close resources
    mysqli_stmt_close($stmt);
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

    <form action="register.php" method="post" onsubmit="return isvalid()">
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
