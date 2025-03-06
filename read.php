
<!DOCTYPE html>
<?php
    session_start();
    include("connection.php");
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM ratings WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
    }
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>View Data</title>
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

    <h1>ID</h1>
    <?php echo $row['id']?>
    <h1>Username</h1>
    <?php echo $row['username']?>
    <h1>Song Title</h1>
    <?php echo $row['song']?>
    <h1>Artist Name</h1>
    <?php echo $row['artist']?>
    <h1>User Rating</h1>
    <?php echo $row['rating']?>
    <br>
    <a href="welcome.php">Go Back</a>
</body>
</html>
