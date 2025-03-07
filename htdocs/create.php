
<!DOCTYPE html>
<?php
    session_start();
    include("connection.php");
    //When button is pressed, inserts the data from the form to the ratings table.
    if(isset($_POST['btn'])){
        $song = $_POST['song'];
        $artist = $_POST['artist'];
        $rating = $_POST['rating'];
        $user = $_SESSION['username'];
        $stmt = $conn->prepare("INSERT INTO ratings(username, song, artist, rating) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $user, $song, $artist, $rating);
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
        <title>Create New Entry</title>
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
<!-- Form asks for a song, artist, and rating. Song and artist are strings, ratings are numbers 0-9. -->
    <div id="form">
        <h1>Enter data here:</h1>
        <form name="form" Onsubmit="return isvalid()" method="POST">
            
            <label>Song: </label>
            <input type="text" id="song" name="song">
        </br></br>
            <label>Artist: </label>
            <input type="text" id="artist" name="artist">
        </br></br>
            <label>Rating: </label>
            <input type="number" step="1" onchange="this.value = Math.max(0, Math.min(9, parseInt(this.value)));" name ="rating">
        </br></br>
            <input type="submit" id="btn" value="submit" name="btn">

    </div>
    <a href="welcome.php">Go Back</a>
    <script>
        //Checks to make sure song and artist fields are empty, rating is already checked in the form.
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
