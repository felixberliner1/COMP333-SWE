<!DOCTYPE html>
<?php
    session_start();
    include "connection.php";
    //If button is pressed, gets the id from welcome and deletes the entry.
    if(isset($_GET['id']) && isset($_POST['btn'])){
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM ratings WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("location:welcome.php");
    }
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Delete Entry?</title>
    </head>
    <body>
    <?php
    //Logout button
    if(isset($_POST['logout'])) {
        $_SESSION = array();
        session_destroy();
        header("location:index.php");
    }
    ?>
    You are currently logged in as: <?php echo $_SESSION['username']?>
    <form method="post">
        <input type="submit" name="logout"
            value="log out?"/>
    </form>
<!-- Form asks if you want to delete the entry and sends you back if you say no -->
        Please confirm if you really want to delete this entry.
        <div id="form">
        <form name="form" method="POST">
            <input type="submit" id="btn" value="yes" name="btn">
        </div>
        <a href="welcome.php">No</a>
    </body>
</html>
