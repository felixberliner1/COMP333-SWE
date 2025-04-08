<?php
session_start();
include("connection.php");

$database = new Database();
$conn = $database-> getConnection();

header("Content-Type: application/json");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM ratings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            "id" => $row['id'],
            "username" => $row['username'],
            "song" => $row['song'],
            "artist" => $row['artist'],
            "rating" => $row['rating']
        ]);
        http_response_code(200);
    } else {
        echo json_encode(["message" => "Record not found."]);
        http_response_code(404);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["message" => "ID parameter is required."]);
    http_response_code(400);
}
?>
