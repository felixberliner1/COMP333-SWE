<?php
session_start();
include("connection.php");

$database = new Database();
$conn = $database->getConnection();

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'], $data['song'], $data['artist'], $data['rating'])) {
        $origID = $data['id'];
        $song = $data['song'];
        $artist = $data['artist'];
        $rating = $data['rating'];

        $stmt = $conn->prepare("UPDATE ratings SET song = ?, artist = ?, rating = ? WHERE id = ?");
        $stmt->bind_param("ssii", $song, $artist, $rating, $origID);

        $stmt->execute();
        echo json_encode(["message" => "Rating updated successfully."]);
        http_response_code(200);

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["message" => "ID, Song, Artist, and Rating are required."]);
        http_response_code(400);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $origID = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM ratings WHERE id = ?");
        $stmt->bind_param("i", $origID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $origRow = $result->fetch_assoc();
            echo json_encode([
                'id' => $origRow['id'],
                'song' => $origRow['song'],
                'artist' => $origRow['artist'],
                'rating' => $origRow['rating']
            ]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Record not found."]);
            http_response_code(404);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["message" => "ID is required for fetching data."]);
        http_response_code(400);
    }
} else {
    echo json_encode(["message" => "Invalid request method. Use GET or PUT."]);
    http_response_code(405);
}
?>
