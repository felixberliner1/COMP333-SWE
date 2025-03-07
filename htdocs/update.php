
<!DOCTYPE html>
<?php
    session_start();
    include("connection.php");
    //Get the data for the original row to display in the form
    if(isset($_GET['id'])){
        $origID = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM ratings WHERE id = ?");
        $stmt->bind_param("i", $origID);
        $stmt->execute();
        $result = $stmt->get_result();
        $origRow = $result->fetch_assoc();
        $stmt->close();
    }
    //Updates the row in the ratings table when the submit button is pressed
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
    //Ends the session and send user back to index.php when logged out
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
<!-- Form includes data fields for the song, artist, and rating. The forms should start containing the values for the original data.-->
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
        //Checks to make sure that the song and artist fields can't be empty. The rating should be taken care of in teh form field already.
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
