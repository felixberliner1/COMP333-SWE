<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <?php
    if(isset($_POST['logout'])) {
        $_SESSION = array();
        session_destroy();
        header("location:index.php");
    }
    ?>
    You are currently logged in as: <?php echo $_SESSION['username'] ?>
    <form method="post">
        <input type="submit" name="logout" value="Log out" />
    </form>

    <h1>Song Ratings</h1>
    <a href="create.php">Add new entry</a>

    <table id="ratings-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>USER</th>
                <th>SONG</th>
                <th>ARTIST</th>
                <th>RATING</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <script>
        function fetchRatings() {
            $.ajax({
                url: 'http://localhost/myapi/update.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var rows = '';
                    data.forEach(function(row) {
                        if (row.username === '<?php echo $_SESSION['username']; ?>') {
                            rows += '<tr>' +
                                '<td>' + row.id + '</td>' +
                                '<td>' + row.username + '</td>' +
                                '<td>' + row.song + '</td>' +
                                '<td>' + row.artist + '</td>' +
                                '<td>' + row.rating + '</td>' +
                                '<td>' +
                                    '<a href="read.php?id=' + row.id + '">READ</a>' +
                                    '<a href="update.php?id=' + row.id + '">UPDATE</a>' +
                                    '<a href="delete.php?id=' + row.id + '">DELETE</a>' +
                                '</td>' +
                            '</tr>';
                        } else {
                            rows += '<tr>' +
                                '<td>' + row.id + '</td>' +
                                '<td>' + row.username + '</td>' +
                                '<td>' + row.song + '</td>' +
                                '<td>' + row.artist + '</td>' +
                                '<td>' + row.rating + '</td>' +
                                '<td>' +
                                    '<a href="read.php?id=' + row.id + '">READ</a>' +
                                '</td>' +
                            '</tr>';
                        }
                    });
                    $('#ratings-table tbody').html(rows);
                },
                error: function() {
                    alert('Error fetching data.');
                }
            });
        }

        $(document).ready(function() {
            fetchRatings();
        });
    </script>

</body>
</html>
