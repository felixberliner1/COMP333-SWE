<!DOCTYPE html>
<?php session_start() ?>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
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

    <h1>Song Ratings</h1>
 
<!-- Add entry to CRUD table-->
    <a>Add new entry: </a>
    <?php echo '<a href = "create.php">CREATE</a>'; ?>

<!--CRUD table begins here -->
    <table>
    <tr>
        <th>ID</th>
        <th>USER</th>
        <th>SONG</th>
        <th>ARTIST</th>
        <th>RATING</th>
        <th>ACTION</th>
    </tr>
        <?php
            include "connection.php";
            $sql = "select * from ratings";
            $result = $conn->query($sql);
            if(!$result){
                echo "ERROR";
            }
            else{
                while($row=$result->fetch_assoc()){
                    //This table contains data for the ratings table.
                    //If the username of the row is currently logged in, adds the update and delete buttons to the table. Otherwise, should just show the read option.
                    if ($_SESSION['username'] == $row['username'])
                    {
                        $out_value = "<tr>
                        <!-- First couple column entries are just data from table -->
                        <td>$row[id]</td>
                        <td>$row[username]</td>
                        <td>$row[song]</td>
                        <td>$row[artist]</td>
                        <td>$row[rating]</td>

                        <!-- Next row are the action buttons-->
                        <td>
                            <!-- Add classes for CSS and links when functionality is added -->
                            <a href = 'read.php?id=$row[id]'>READ</a>
                            <a href = 'update.php?id=$row[id]'>UPDATE</a>
                            <a href = 'delete.php?id=$row[id]'>DELETE</a>
                        </td>

                        </tr>";
                    }
                    else {
                        $out_value = "<tr>
                        <!-- First couple column entries are just data from table -->
                        <td>$row[id]</td>
                        <td>$row[username]</td>
                        <td>$row[song]</td>
                        <td>$row[artist]</td>
                        <td>$row[rating]</td>

                        <!-- Next row are the action buttons-->
                        <td>
                            <!-- Add classes for CSS and links when functionality is added -->
                            <a href = 'read.php?id=$row[id]'>READ</a>
                        </td>

                        </tr>";
                    }
                    echo $out_value;
                }
            }
        ?>
    </table> 
</body>
</html>
