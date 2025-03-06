<!DOCTYPE html>
<?php
    session_start();
    include "connection.php";
    if(isset($_GET['id']) && isset($_POST['btn'])){
        $id = $_GET['id'];
        $sql = "DELETE from ratings where id=$id";
        $conn->query(query: $sql);
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

        Please confirm if you really want to delete this entry.
        <div id="form">
        <form name="form" method="POST">
            <input type="submit" id="btn" value="yes" name="btn">
        </div>
        <a href="welcome.php">No</a>
    </body>
</html>
