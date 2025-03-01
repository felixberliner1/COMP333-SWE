<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Song Ratings</h1>
<!-- Later: add a log out button and test saying who is logged in-->
 
<!-- Add entry to CRUD table-->
    <a>Add new entry</a>

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
            while($row=$result->fetch_assoc()){
                echo 
                "<tr>
                    <!-- First couple column entries are just data from table -->
                    <td>$row[id]</td>
                    <td>$row[username]</td>
                    <td>$row[song]</td>
                    <td>$row[artist]</td>
                    <td>$row[rating]</td>

                    <!-- Next row are the action buttons-->
                    <td>
                        <!-- Add classes for CSS and links when functionality is added -->
                        <a>VIEW</a>
                        <a>UPDATE</a>
                        <a>DELETE</a>
                    </td>

                </tr>";
            }
        ?>
    </table> 
</body>
</html>
