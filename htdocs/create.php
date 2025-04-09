<?php
session_start();
include("connection.php");

$database = new Database();
$conn = $database->getConnection();

header("Content-Type: application/json");

if (!isset($_SESSION['username'])) {
    echo json_encode(["message" => "User not logged in."]);
    http_response_code(403);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['song'], $data['artist'], $data['rating'])) {
        $song = $data['song'];
        $artist = $data['artist'];
        $rating = $data['rating'];
        $user = $_SESSION['username'];

        $stmt = $conn->prepare("INSERT INTO ratings(username, song, artist, rating) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $user, $song, $artist, $rating);
        $stmt->execute();
        $stmt->close();

        echo json_encode(["message" => "Rating submitted successfully."]);
        http_response_code(201);
    } else {
        echo json_encode(["message" => "Missing required fields."]);
        http_response_code(400);
    }
} else {
    echo json_encode(["message" => "Invalid request method. Use POST."]);
    http_response_code(405);
}

mysqli_close($conn);
?>
