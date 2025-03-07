
<!DOCTYPE html>
<?php
    session_start();
    include("connection.php");
    if(isset($_GET['id'])){
        $origID = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM ratings WHERE id = ?");
        $stmt->bind_param("i", $origID);
        $stmt->execute();
        $result = $stmt->get_result();
        $origRow = $result->fetch_assoc();
        $stmt->close();
    }
    if(isset($_POST['btn'])){
        $song = $_POST['song'];
        $artist = $_POST['artist'];
        $rating = $_POST['rating'];
        $user = $_SESSION['username'];
        $stmt = $conn->prepare("UPDATE ratings SET song = ?, artist = ?, rating = ? WHERE id = ?");
        $stmt->bind_param("ssii", $song, $artist, $rating, $origID);
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
        <title>Update Data</title>
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

    <div id="form">
        <h1>Enter data here:</h1>
        <form name="form" Onsubmit="return isvalid()" method="POST">
            
            <label>Song: </label>
            <input type="text" id="song" name="song" value="<?php echo "$origRow[song]"; ?>">
        </br></br>
            <label>Artist: </label>
            <input type="text" id="artist" name="artist" value="<?php echo "$origRow[artist]"; ?>">
        </br></br>
            <label>Rating: </label>
            <input type="number" step="1" onchange="this.value = Math.max(0, Math.min(9, parseInt(this.value)));" name ="rating" value="<?php echo "$origRow[rating]"; ?>">
        </br></br>
            <input type="submit" id="btn" value="submit" name="btn">

    </div>
    <a href="welcome.php">Go Back</a>
    <script>
        function isvalid(){
            var song = document.form.song.value;
            var artist = document.form.artist.value;
            var rating = document.form.rating.value;
            if(song.length=="") {
                alert("Song name is empty.");
                return false
            }
            if(artist.length=="") {
                alert("Artist name is empty.")
                return false
            }
        }
    </script>
</body>
</html>
